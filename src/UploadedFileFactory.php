<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\UploadedFileFactoryInterface;
use \Psr\Http\Message\UploadedFileInterface;
use \Psr\Http\Message\StreamInterface;

class UploadedFileFactory implements UploadedFileFactoryInterface{
    public function createUploadedFile(
        StreamInterface $stream,
        int $size=NULL,
        int $error=\UPLOAD_ERR_OK,
        string $clientFilename=NULL,
        string $clientMediaType=NULL
    ): UploadedFileInterface{
        return new UploadedFile(
            $stream,
            $size,
            $error,
            $clientFilename,
            $clientMediaType
        );
    }
}
