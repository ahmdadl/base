<?php

declare(strict_types=1);

namespace App\Controllers;

use app\Util\Password;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileUploader
{
    private $file;

    /**
     * set the file instance
     *
     * @param array $files
     * @return void
     */
    private function setUploader(array $files): void
    {
        $files = (object) $files;

        $this->file = new UploadedFile(
            $files->tmp_name,
            $files->name,
            $files->type,
            $files->error
        );
    }

    /**
     * upload file to specific location
     *
     * @param object $files
     * @param string $targetDir
     * @return string|false
     */
    private function upload(string $targetDir = '')
    {
        $originalFilename = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = Password::randStr(7);
        $fileName = $safeFilename . uniqid() . '.' . $this->file->guessExtension();

        // target file will be relative to root folder
        $targetDir = dirname(dirname(__DIR__)) . '/' . $targetDir;

        if ($this->file->move($targetDir, $fileName)) {
            return $fileName;
        }

        return false;
    }

    /**
     * validate file size and type
     *
     * @param integer $sizeKB
     * @param array $types
     * @return object
     */
    private function validate(int $sizeKB, array $types) : object
    {
        $error = (object) [
            'size' => true,
            'type' => true
        ];

        if ($this->file->isvalid()) {
            $error->size = $error->type = false;
            
            foreach ($types as $type) {
               
                if ('image/' . $type === $this->file->getClientMimeType()) {
                    $error->type = true;
                    break;
                }
            }

            if (($this->file->getSize()/1024) <= $sizeKB) {
                $error->size = true;
            }
        }

        return $error;
    }
}
