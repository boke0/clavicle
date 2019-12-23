<?php

namespace Boke0\Clavicle;

trait Message{
    public function getProtocolVersion(){
        return $this->version;
    }
    public function withProtocolVersion($version){
        $response=clone $this;
        $response->version=$version;
        return $response;
    }
    public function getHeaders(){
        return $this->headers;
    }
    public function hasHeader($name){
        return isset($this->headers[$name]);
    }
    public function getHeader($name){
        return implode(",",$this->headers[$name]);
    }
    public function getHeaderLine($name){
        return "{$name}:".$this->getHeader($name);
    }
    public function withHeader($name,$value){
        $response=clone $this;
        $headers=$this->getHeaders();
        if($value instanceof string){
            $value=explode(",",$value);
        }
        $headers[$name]=$value;
        $response->headers=$headers;
        return $response;
    }
    public function withAddedHeader($name,$value){
        $response=clone $this;
        $headers=$this->getHeaders();
        if(empty($headers[$name])){
            $headers[$name]=array();
        }
        array_push($headers[$name],$value);
        $response->headers=$headers;
        return $response;
    }
    public function withoutHeader($name){
        $response=clone $this;
        $headers=$this->getHeaders();
        unset($headers[$name]);
        $response->headers=$headers;
        return $response;
    }
    public function getBody(){
        return $this->body;
    }
    public function withBody(StreamInterface $body){
        $response=clone $this;
        $response->body=$body;
        return $response;
    }
}
