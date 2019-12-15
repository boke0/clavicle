<?php

namespace Boke0\Clavicle;

use \Psr\Http\Message\UriInterface;

class Uri implements UriInterface{
    public function __construct($scheme,$host,$user,$port,$path,$query,$fragment){
        $this->scheme=$scheme;
        $this->host=$host;
        $this->user=$user;
        $this->port=$port;
        $this->path=$path;
        $this->query=$query;
        $this->fragment=$fragment;
    }
    public function getScheme(){
        return (string)$this->scheme;
    }
    public function getHost(){
        return (string)$this->host;
    }
    public function getUserInfo(){
        return (string)$this->user;
    }
    public function getPort(){
        return isset($this->port)?intval($this->port):NULL;
    }
    public function getPath(){
        return (string)$this->path;
    }
    public function getQuery(){
        return (string)$this->query;
    }
    public function getFragment(){
        return (string)$this->fragment;
    }
    public function __toString(){
        $url="";
        if($this->scheme!="") $url="{$this->scheme}://";
        if($this->user!="") $url.="{$this->user}@";
        if($this->host!="") $url.=$this->host;
        if($this->port!="") $url.=":{$this->port}";
        if($this->path!="") $url.=$this->path;
        if($this->query!="") $url.="?{$this->query}";
        if($this->fragment!="") $url.="#{$this->fragment}";
        return $url;
    }
    public function withScheme($scheme){
        $uri=clone $this;
        $uri->scheme=$scheme;
        return $uri;
    }
    public function withUserInfo($user,$password=NULL){
        $user=(string)$this->uri["user"];
        if(isset($this->uri["pass"])) $user.=":{$this->uri["pass"]}";
        $uri=clone $this;
        $uri->user=$user;
        return $uri;
    }            
    public function withHost($host){
        $uri=clone $this;
        $uri->host=$host;
        return $uri;
    }
    public function withPort($port){
        $uri=clone $this;
        $uri->port=$port;
        return $uri;
    }
    public function withPath($path){
        $uri=clone $this;
        $uri->path=$path;
        return $uri;
    }
    public function withQuery($query){
        $uri=clone $this;
        $uri->query=$query;
        return $uri;
    }
    public function withFragment($fragment){
        $uri=clone $this;
        $uri->fragment=$fragment;
        return $uri;
    }
}
