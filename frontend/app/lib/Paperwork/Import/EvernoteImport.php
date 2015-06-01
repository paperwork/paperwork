<?php
/**
 * Created by PhpStorm.
 * User: Borys Anikiyenko
 * Date: 03.02.2015
 */

namespace Paperwork\Import;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EvernoteImport extends AbstractImport
{
    /**
     * Method parse Evernote notes.
     * Create notebook and goes through all notes in xml
     */
    public function process()
    {
        if (isset($this->xml['note'])) {
            $this->createNotebook('Evernote');

            // libxml returns single element instead of array if 1 note
            if (isset($this->xml['note']['content'])) {
                $this->xml['note'] = [$this->xml['note']];
            }

            libxml_use_internal_errors(true);
            foreach ($this->xml['note'] as $note) {
                $this->createEvernoteNote($note, $this->getNoteContent($note));
            }
            libxml_use_internal_errors(false);
        }
    }

    /**
     * Identify parser class for xml
     * Use @attributes property
     *
     * @return bool|string
     */
    protected function checkXmlSource()
    {
        if (isset($this->xml['@attributes'], $this->xml['@attributes']['application']) && preg_match('/evernote/i', $this->xml['@attributes']['application'])) {
            return 'Paperwork\PaperwokImportEvernote';
        }

        return false;
    }

    /**
     * Try parse file by SimpleXml
     *
     * @param UploadedFile $file
     * @return bool|uid
     */
    public function import(UploadedFile $file)
    {
        try {
            $this->xml = simplexml_load_file($file->getRealPath(), 'SimpleXMLElement', LIBXML_PARSEHUGE | LIBXML_NOCDATA);
            $this->xml = json_decode(json_encode($this->xml), true);

            if ($this->xml && $parser = $this->checkXmlSource()) {
                $this->process();

                return $this->notebook->id;
            }
        } catch (Exception $e) {
        }

        return false;
    }


    /**
     * Fetch html from xml note
     *
     * @param $note
     * @return string
     */
    protected function getNoteContent($note)
    {
        // Get content from xml. Use DOMDocument
        $doc = new \DOMDocument;
        $doc->loadHTML($note['content']);

        // Remove xml, doctype and body tags
        $body = new \DOMDocument();
        $cloned = $doc->getElementsByTagName('body')->item(0)->cloneNode(true);
        $body->appendChild($body->importNode($cloned, true));
        $res = str_replace(array('<body>', '</body>', '<en-note', '</en-note>'), array('', '', '<div', '</div>'), $body->saveHTML());
        return mb_convert_encoding($res, 'UTF-8', 'HTML-ENTITIES');
    }

    /**
     * Create note, tags and attachments
     * I expected that $xmlNote has 'created' and 'created' times
     *
     * @param $xmlNote
     * @param string $content
     */
    protected function createEvernoteNote($xmlNote, $content)
    {
        $noteInstance = $this->createNote($xmlNote['title'], $content, strtotime($xmlNote['created']), (isset($xmlNote['updated'])) ? strtotime($xmlNote['updated']) : strtotime($xmlNote['created']));

        if (isset($xmlNote['tag'])) {
            $this->processTag($xmlNote, $noteInstance);
        }

        if (isset($xmlNote['resource'])) {
            $this->processFile($xmlNote, $noteInstance);
        }
    }

    /**
     * Fetch tags from xml['tag']
     *
     * @param $xmlNote
     * @param \Note $noteInstance
     */
    protected function processTag($xmlNote, $noteInstance)
    {
        $tagsIds = [];

        // Can be single element if 1 tag
        if (!is_array($xmlNote['tag'])) {
            $xmlNote['tag'] = [$xmlNote['tag']];
        }
        foreach ($xmlNote['tag'] as $tag) {
            $tagCreate = $this->createTag($tag);
            $tagsIds[] = $tagCreate->id;
        }

        $noteInstance->tags()->sync($tagsIds);
    }

    /**
     * Fetch attachments from xml['resource']
     * Use base64
     * Replace attachments links in note's content: <en-media...
     *
     *
     * @param $xmlNote
     * @param \Note $noteInstance
     * @throws \Exception
     */
    protected function processFile($xmlNote, $noteInstance)
    {
        if (isset($xmlNote['resource']['data'])) {
            $xmlNote['resource'] = [$xmlNote['resource']];
        }

        foreach ($xmlNote['resource'] as $attachment) {
            // No name? Use rand
            $fileName = (isset($attachment['resource-attributes'], $attachment['resource-attributes']['file-name'])) ? $attachment['resource-attributes']['file-name'] : uniqid(rand(), true);

            $fileContent = base64_decode($attachment['data']);
            $fileHash = md5($fileContent);

            $newAttachment = $this->createAttachment($fileContent, $fileName, $attachment['mime']);

            $noteVersion = $noteInstance->version()->first();

            // FIXME THAT'S MESS
            // TODO: review regexp - need to fetch style attribute in another way.
            // replace en-media tag by img
            if (str_contains($attachment['mime'], 'image')) {
                $noteVersion->content = preg_replace('/<en-media[^>]*hash="' . $fileHash . '"([^>]*)><\/en-media>/', '<img $1 src="/api/v1/notebooks/' . $this->notebook->id . '/notes/' . $noteInstance->id . '/versions/' . $noteVersion->id . '/attachments/' . $newAttachment->id . '/raw" />', $noteVersion->content);
            } else {
                $noteVersion->content = preg_replace('/<en-media[^>]*hash="' . $fileHash . '"([^>]*)><\/en-media>/', '<a $1 href="/api/v1/notebooks/' . $this->notebook->id . '/notes/' . $noteInstance->id . '/versions/' . $noteVersion->id . '/attachments/' . $newAttachment->id . '/raw">' . $fileName . '</a>', $noteVersion->content);
            }

            $noteVersion->attachments()->attach($newAttachment);
            $noteVersion->save();

            // Doesn't work.
            // \Queue::push('DocumentParserWorker', array('user_id' => \Auth::user()->id, 'document_id' => $newAttachment->id));
        }
    }
}