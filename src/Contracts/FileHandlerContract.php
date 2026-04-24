<?php
declare(strict_types=1);

namespace Kapil\FileHandler\Contracts;

interface FileHandlerContract
{
    /**
     * Upload a file to the specified directory.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @param array $options
     * @return mixed
     */
    public function upload(
        \Illuminate\Http\UploadedFile $file,
        string $directory,
        array $options = []
    );
}