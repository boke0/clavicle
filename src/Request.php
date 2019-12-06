<?php

namespace Boke0;
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\StreamInterface;
use \Psr\Http\Message\UriInterface;
use 

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
        $this->headers=[];
        foreach($headers as $name=>$value){
            $this->headers[$name]=($value instanceof array)?$value:explode(",",$value);
        }
        $this->body=$body;
    }
    public function getProtocolVersion(){
        return $this->version; 
    }
    public function withProtocolVersion($version){
        return new Request(
            $version,
            $this->method,
            $this->uri,
            $this->headers,
            $this->body
        );
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
        if($value instanceof string){
            $value=explode(",",$value);
        }
        $headers=$this->getHeaders();
        $headers[$name]=$value;
        return new Request(
            $this->protocol,
            $this->method,
            $headers,
            $this->uri,
            $this->body
        );
    }
    public function withAddedHeader($name,$value){
        $headers=$this->getHeaders();
        if(empty($headers[$name])){
            $headers[$name]=array();
        }
        array_push($headers[$name],$value);
        return new Request(
            $this->version,
            $this->method,
            $headers,
            $this->uri,
            $this->body
        );
    }
    public function withoutHeader($name){
        $headers=$this->getHeaders();
        unset($headers[$name]);
        return new Request(
            $this->version,
            $this->method,
            $headers,
            $this->uri,
            $this->body
        );
    }
    public function getBody(){
        return $this->body;
    }
    public function withBody(StreamInterface $body){
        return new Request(
            $this->version,
            $this->method,
            $this->headers,
            $this->uri,
            $body
        );
    }
} 
