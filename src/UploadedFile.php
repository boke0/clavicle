<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\UploadedFileInterface;
use \Psr\Http\Message\StreamFactoryInterface;
use \Psr\Http\Message\StreamInterface;

class UploadedFile implements UploadedFileInterface{
    public function __construct(
        StreamInterface $stream,
        int $size=NULL,
        int $error=\UPLOADED_ERR_OK,
        string $clientFilename=NULL,
        string $clientMediaType=NULL
    ){
        $this->streamFactory=new StreamFactory();
        $this->stream=$stream;
        $this->size=$size;
        $this->error=$error;
        $this->clientFilename=$clientFilename;
        $this->clientMediaType=$clientMediaType;
    }
    public function getStream(){
        return $this->stream;
    }
    public function moveTo($target){
        $content=$this->stream->getStream();
        $stream=$this->streamFactory->createStreamFromFile($target);
        $stream->write($content);
        $stream->close();
    }
    public function getSize(){
        return $this->size;
    }
    public function getError(){
        return $this->error;
    }
    public function getClientFilename(){
        return $this->clientFilename;
    }
    public function getClientMediaType(){
        return $this->clientMediaType;
    }
}
