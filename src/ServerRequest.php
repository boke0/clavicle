<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\StreamInterface;
use \Psr\Http\Message\UriInterface;

class ServerRequest extends Request implements ServerRequestInterface{
    public function getServerParams(){
        return $this->serverParams;
    }
    public function getCookieParams(){
        return $this->cookieParams;
    }
    public function withCookieParams(array $cookies){
        $serverRequest=clone $this;
        $serverRequest->cookieParams=$cookies;
        return $serverRequest;
    }
    public function getQueryParams(){
        return $this->queryParams;
    }
    public function withQueryParams(array $query){
        $serverRequest=clone $this;
        $serverRequest->queryParams=$query;
        return $serverRequest;
    }
    public function getUploadedFiles(){
        return $this->uploadedFiles;
    }
    public function withUploadedFiles(array $files){
        $serverRequest=clone $this;
        $serverRequest->uploadedFiles=$files;
        return $serverRequest;
    }
    public function getParsedBody(){
        return $this->parsedBody;
    }
    public function withParsedBody($data){
        if($data instanceof object){
            $data=(array)$data;
        }else if(isset($data)&&!is_array($data)){
            throw new \InvalidArgumentException("Unsupported type of data");
        }
        $this->parsedBody=$data;
    }
    public function getAttributes(){
        return $this->attribute;
    }
    public function getAttribute($name){
        return $this->attribute[$name];
    }
    public function withAttribute($name,$value){
        $serverRequest=clone $this;
        $serverRequest->attribute[$name]=$value;
        return $serverRequest;
    }
    public function withoutAttribute($name){
        $serverRequest=clone $this;
        unset($serverRequest->attribute[$name]);
        return $serverRequest;
    }
}
