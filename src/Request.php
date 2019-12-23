<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\StreamInterface;
use \Psr\Http\Message\UriInterface;

class Request implements RequestInterface{
    use Message;
    public function __construct(
        $version,
        string $method,
        $uri,
        $headers=[],
        StreamInterface $body
    ){
        $this->version=$version;
        $this->method=strtoupper($method);
        if(!$uri instanceof UriInterface){
            $parsed=parse_url($uri);
            $user=isset($parsed["pass"])?"{$parsed["user"]}:{$parsed["pass"]}":$parsed["user"];
            $uri=new Uri(
                $parsed["scheme"],
                $user,
                $parsed["host"],
                $parsed["port"],
                $parsed["path"],
                $parsed["query"],
                $parsed["fragment"]
            );
        }
        $this->uri=$uri;
        $this->headers=array();
        foreach($headers as $name=>$value){
            $this->headers[$name]=is_array($value)?$value:explode(",",$value);
        }
        $this->body=$body;
    }
    public function getRequestTarget(){
        return $this->requetTarget;
    }
    public function withRequestTarget($target){
        $request=clone $this;
        $request->requestTarget=$target;
        return $request;
    }
    public function getMethod(){
        return $this->method;
    }
    public function withMethod($method){
        $request=clone $this;
        $request->method=$method;
        return $request;
    }
    public function getUri(){
        return $this->uri;
    }
    public function withUri(UriInterface $uri,$preserverHost=false){
        $request=clone $this;
        $request->uri=$uri;
        if($preserveHost){
            return $request;
        }else{
            return $request->withHeader("Host",$uri->getHost());
        }
    }
} 
