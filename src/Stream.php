<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface{
    public function __construct($stream){
        $this->fp=$stream;
    }
    public function __toString(){
        return stream_get_contents($this->stream);
    }
    public function close(){
        fclose($this->fp);
    }
    public function detach(){
        $result=$this->fp;
        unset($this->fp);
        return $result;
    }
    public function getSize(){
        if(empty($this->size)) $this->size=fstat($this->fp)->size;
        return $this->size;
    }
    public function tell(){
        return ftell($this->fp);
    }
    public function eof(){
        return feof($this->fp);
    }
    public function isSeekable(){
        $result=fseek($this->fp,1,\SEEK_CUR);
        if($result==-1){
            return FALSE;
        }else{
            fseek($this->fp,-1,\SEEK_CUR);
            return TRUE;
        }
    }
    public function seek($offset,$whence=\SEEK_SET){
        fseek($this->fp,$offset,$whence);
    }
    public function rewind(){
        fseek($this->fp,0);
    }
    public function isWritable(){
        return is_writable($this->fp);
    }
    public function write($string){
        fwrite($this->fp,$string);
    }
    public function isReadable(){
        return is_readable($this->fp);
    }
    public function read($length){
        return fread($this->fp,$length);
    }
    public function getContents(){
        $data=stream_get_contents($this->fp);
        if($this->isSeekable()) $this->rewind();
        return $data;
    }
    public function getMetadata($key=NULL){
        if(empty($this->meta)) $this->meta=stream_get_meta_data($this->fp);
        return isset($key)?$this->meta->$key:$this->meta;
    }
}
