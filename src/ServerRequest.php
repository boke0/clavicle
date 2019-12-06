<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\StreamInterface;
use \Psr\Http\Message\UriInterface;

class ServerRequest implements ServerRequestInterface{
    public function __construct(
        $version,
        $method,
        $uri,
        $headers,
        StreamInterface $body,
        $serverParams=NULL,
        $cookieParams=NULL,
        $queryParams=NULL,
        $uploadedFiles=NULL,
        $attributes=NULL
    ){
        $this->version=$version;
        $this->method=setuppercase($method);
        if(!$uri instanceof UriInterface) $uri=new Uri($uri);
        $this->uri=$uri;
        $this->headers=[];
        foreach($headers as $name=>$value){
            $this->headers[$name]=($value instanceof array)?$value:explode(",",$value);
        }
        $this->body=$body;
        if(isset($serverParams)){
            foreach($_SERVER as $k=>$v){
                $this->serverParams[$k]=$v;
            }
        }else{
            $this->serverParams=$serverParams;
        }
        if(isset($cookieParams)){
            foreach($_COOKIE as $k=>$v){
                $this->cookieParams[$k]=$v;
            }
        }else{
            $this->cookieParams=$cookieParams;
        }
        if(isset($queryParams)){
            foreach($_GET as $k=>$v){
                $this->queryParams[$k]=$v;
            }
        }else{
            $this->queryParams=$queryParams;
        }
        if(isset($uploadedFiles)){
            if(isset($_FILES)){
                foreach($_FILES as $k=>$v){
                    $this->uploadedFiles[$k]=new UploadedFile($v);
                }
            }
        }else{
            $this->uploadedFiles=$uploadedFiles;
        }
        switch($this->method){
            case "POST":
                foreach($_POST as $k=>$v){
                    $this->parsedBody[$k]=$v;
                }
                break;
            case "PUT":
            case "DELETE":
                $this->parsedBody=parse_str($body->_toString());
                break;
        }
        $this->attributes=$attributes;
    }
    public function getServerParams(){
        return $this->serverParams;
    }
    public function getCookieParams(){
        return $this->cookieParams;
    }
    public function withCookieParams(array $cookies){
        return new ServerRequest(
            $this->version,
            $this->method,
            $this->uri,
            $this->headers,
            $this->body,
            $this->serverParams,
            $cookie,
            $this->queryParams,
            $this->uploadedFiles,
            $this->attributes
        );
    }
    public function getQueryParams(){
        return $this->queryParams;
    }
    public function withQueryParams(array $query){
        return new ServerRequest(
            $this->version,
            $this->method,
            $this->uri,
            $this->headers,
            $this->body,
            $this->serverParams,
            $this->cookieParams,
            $query,
            $this->uploadedFiles,
            $this->attributes
        );
    }
    public function getUploadedFiles(){
        return $this->uploadedFiles;
    }
    public function withUploadedFiles(array $files){
        $files=array_merge($files,$this->uploadedFiles);
        return new ServerRequest(
            $this->version,
            $this->method,
            $this->uri,
            $this->headers,
            $this->body,
            $this->serverParams,
            $this->cookieParams,
            $this->queryParams,
            $files,
            $this->attributes
        );
    }
    public function getParsedBody(){
        return $this->parsedBody;
    }
    public function getAttributes(){
        return $this->attribute;
    }
    public function getAttribute($name){
        return $this->attribute[$name];
    }
    public function withAttribute($name,$value){
        $attributes=$this->getAttributes();
        $attributes[$name]=$value;
        return new ServerRequest(
            $this->version,
            $this->method,
            $this->uri,
            $this->headers,
            $this->body,
            $this->serverParams,
            $this->cookieParams,
            $this->queryParams,
            $this->uploadedFiles,
            $attributes
        );
    }
    public function withoutAttribute($name){
        $attributes=$this->getAttributes();
        unset($attributes[$name]);
        return new ServerRequest(
            $this->version,
            $this->method,
            $this->uri,
            $this->headers,
            $this->body,
            $this->serverParams,
            $this->cookieParams,
            $this->queryParams,
            $this->uploadedFiles,
            $attributes
        );
    }
}
