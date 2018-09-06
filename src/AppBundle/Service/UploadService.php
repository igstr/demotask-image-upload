<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService
{
    /** @var string */
    private $uploadDirectory;

    /**
     * @param string $uploadDirectory
     */
    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    /**
     * Upload a file
     *
     * @param UploadedFile $file
     *
     * @return string Generated filename
     */
    public function upload(UploadedFile $file)
    {
        $filename = md5(uniqid()).'_'.md5($file->getClientOriginalName()).'.'.$file->guessExtension();

        $file->move($this->getUploadDirectory(), $filename);

        return $filename;
    }

    /**
     * Get upload directory
     *
     * @return string
     */
    public function getUploadDirectory()
    {
        return $this->uploadDirectory;
    }
}