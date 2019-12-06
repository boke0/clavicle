<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface{
    public function __construct($file){
        $this->data=$file;
    }
    public function getStream(){
        return new Stream($this->data["tmp_name"]);
    }
    public function moveTo($target){
        move_uploaded_file($this->data["tmp_name"],$target);
    }
    public function getSize(){
        return $this->data["size"];
    }
    public function getError(){
        return $this->data["error"];
    }
    public function getClientFilename(){
        return $this->data["name"];
    }
    public function getClientMediaType(){
        return $this->data["type"];
    }
}
