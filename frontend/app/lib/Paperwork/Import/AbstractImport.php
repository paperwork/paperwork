<?php
/**
 * Created by PhpStorm.
 * User: Borys Anikiyenko
 * Date: 02.02.2015
 */

namespace Paperwork\Import;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractImport implements Import
{
    protected $xml;

    protected $notebook;

    public abstract function import(UploadedFile $file);

    public abstract function process();

    /**
     * @param $title
     */
    protected function createNotebook($title)
    {
        $this->notebook = \Notebook::firstOrCreate([
            'title' => $title
        ]);

        if (! $this->notebook->users->contains(\Auth::user()->id)) {
            $this->notebook->users()->attach(\Auth::user()->id, array('umask' => \PaperworkHelpers::UMASK_OWNER));
        }
    }

    /**
     * @param $title
     * @return \Tag
     */
    protected function createTag($title)
    {
        $tagCreate = \Tag::firstOrCreate([
            'title'      => $title,
            'user_id'    => \Auth::user()->id,
            'visibility' => 0
        ]);

        return $tagCreate;
    }

    /**
     * Create Note and Version instances
     *
     * $created_at and $updated_at values we have from parsed xml
     *
     * @param $title
     * @param $content
     * @param $created_at
     * @param $updated_at
     * @return \Note
     */
    protected function createNote($title, $content, $created_at, $updated_at)
    {
        $noteCreate = new \Note;

        $noteCreate->created_at = $created_at;
        $noteCreate->updated_at = $updated_at;

        // Add spaces for strip_tags
        $contentPreview = preg_replace('/(<[^>]+>)/', '$1 ', $content);
        $contentPreview = strip_tags($contentPreview);

        $versionCreate = new \Version([
            'title'           => $title,
            'content'         => $content,
            'content_preview' => mb_substr($contentPreview, 0, 255),
            'created_at'      => $created_at,
            'updated_at'      => $updated_at,
            'user_id'         => \Auth::user()->id
        ]);
        $versionCreate->save();

        $noteCreate->version()->associate($versionCreate);
        $noteCreate->notebook_id = $this->notebook->id;

        $noteCreate->save();
        $noteCreate->users()->attach(\Auth::user()->id, array('umask' => \PaperworkHelpers::UMASK_OWNER));

        return $noteCreate;
    }

    /**
     * Create Attachment instance and move file to attachmentsDirectory
     *
     * @param $data
     * @param $fileName
     * @param string $mime
     * @return \Attachment
     * @throws \Exception
     */
    protected function createAttachment($data, $fileName, $mime = '')
    {
        if(empty($mime)) {
            $f = finfo_open();
            $mime = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
        }

        $newAttachment = new \Attachment(array(
            'filename'      => $fileName,
            'fileextension' => pathinfo($fileName, PATHINFO_EXTENSION),
            'mimetype'      => $mime,
            'filesize'      => strlen($data)
        ));
        $newAttachment->save();

        $destinationFolder = \Config::get('paperwork.attachmentsDirectory') . '/' . $newAttachment->id;
        if(!\File::makeDirectory($destinationFolder, 0700)) {
            $newAttachment->delete();
            throw new \Exception('Error creating directory');
        }
        file_put_contents($destinationFolder . '/' . $fileName, $data);

        return $newAttachment;
    }
}