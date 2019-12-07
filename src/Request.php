<?php

namespace Boke0;
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\StreamInterface;
use \Psr\Http\Message\UriInterface;

class Request implements RequestInterface{
    public function __construct(
        $version,
        string $method,
        $uri,
        $headers=[],
        StreamInterface $body
    ){
        $this->version=$version;
        $this->method=strtoupper($method);
        $this->uri=($uri instanceof UriInterface)?$uri:new Uri($uri);
        $this->headers=array();
        foreach($headers as $name=>$value){
            $this->headers[$name]=($value instanceof array)?$value:explode(",",$value);
        }
        $this->body=$body;
    }
    public function getProtocolVersion(){
        return $this->version; 
    }
    public function withProtocolVersion($version){
        $request=clone $this;
        $request->version=$version;
        return $request;
    }
    public function getHeaders(){
        return $this->headers;
    }
    public function hasHeader($name){
        return isset($this->headers[$name]);
    }
    public function getHeader($name){
        return implode(",",(array)$this->headers[$name]);
    }
    public function getHeaderLine($name){
        return "{$name}:".$this->getHeader($name);
    }
    public function withHeader($name,$value){
        $request=clone $this;
        if($value instanceof string){
            $value=explode(",",$value);
        }
        $headers=$this->getHeaders();
        $headers[$name]=$value;
        $request->headers=$headers;
        return $request;
    }
    public function withAddedHeader($name,$value){
        $request=clone $this;
        $headers=$this->getHeaders();
        if(empty($headers[$name])){
            $headers[$name]=array();
        }
        array_push($headers[$name],$value);
        $request->headers=$headers;
        return $request;
    }
    public function withoutHeader($name){
        $request=clone $this;
        $headers=$this->getHeaders();
        unset($headers[$name]);
        $request->headers=$headers;
        return $request;
    }
    public function getBody(){
        return $this->body;
    }
    public function withBody(StreamInterface $body){
        $request=clone $this;
        $request->body=$body;
        return $request;
    }
} 
