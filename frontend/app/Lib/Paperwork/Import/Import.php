<?php

namespace Paperwork\Import;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface Import
{
    /**
     * Create notebook and goes through all notes in xml
     */
    public function process();

    public function import(UploadedFile $file);
}