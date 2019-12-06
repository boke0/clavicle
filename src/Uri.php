<?php

namespace Boke0\Clavicle;

use \Psr\Http\Message;

class Uri implements UriInterface{
    public function __construct($uri){
        $this->uri=parse_url($uri);
    }
    public function getScheme(){
        return (string)$this->uri["scheme"];
    }
    public function getHost(){
        return (string)$this->uri["host"];
    }
    public function getUserInfo(){
        $user=(string)$this->uri["user"];
        if(isset($this->uri["pass"])) $user.=":{$this->uri["pass"]}";
        return $user;
    }
    public function getPort(){
        return isset($this->uri["port"])?intval($this->uri["port"]):NULL;
    }
    public function getPath(){
        return (string)$this->uri["path"];
    }
    public function getQuery(){
        return (string)$this->uri["query"];
    }
    public function getFragment(){
        return (string)$this->uri["fragment"];
    }
    public function buildUri($scheme,$user,$host,$prot,$path,$query,$fragment){
        $url="";
        if($scheme!="") $url="{$scheme}://";
        if($user!="") $url.="{$user}@";
        if($host!="") $url.=$host;
        if($port!="") $url.=":{$port}";
        if($path!="") $url.="{$path}";
        if($query!="") $url.="{$query}";
        if($fragment!="") $url.="#{$fragment}";
        return $url;
    }
    public function withScheme($scheme){
        return new Uri($this->buildUri(
            $scheme,
            $this->getUserInfo(),
            $this->getHost(),
            $this->getPort(),
            $this->getPath(),
            $this->getQuery(),
            $this->getFragment()
        ));
    }
    public function withUserInfo($user,$password=NULL){
        $user=(string)$this->uri["user"];
        if(isset($this->uri["pass"])) $user.=":{$this->uri["pass"]}";
        return new Uri($this->buildUri(
            $this->getScheme(),
            $user,
            $this->getHost(),
            $this->getPort(),
            $this->getPath(),
            $this->getQuery(),
            $this->getFragment()
        ));
    }            
    public function withHost($host){
        return new Uri($this->buildUri(
            $this->getScheme(),
            $this->getUserInfo(),
            $host,
            $this->getPort(),
            $this->getPath(),
            $this->getQuery(),
            $this->getFragment()
        ));
    }
    public function withPort($port){
        return new Uri($this->buildUri(
            $this->getScheme(),
            $this->getUserInfo(),
            $this->getHost(),
            $port
            $this->getPath(),
            $this->getQuery(),
            $this->getFragment()
        ));
    }
    public function withPath($path){
        return new Uri($this->buildUri(
            $this->getScheme(),
            $this->getUserInfo(),
            $this->getHost(),
            $this->getPort(),
            $path,
            $this->getQuery(),
            $this->getFragment()
        ));
    }
    public function withQuery($query){
        return new Uri($this->buildUri(
            $this->getScheme(),
            $this->getUserInfo(),
            $this->getHost(),
            $this->getPort(),
            $this->getPath(),
            $query,
            $this->getFragment()
        ));
    }
    public function withFragment($fragment){
        return new Uri($this->buildUri(
            $this->getScheme(),
            $this->getUserInfo(),
            $this->getHost(),
            $this->getPort(),
            $this->getPath(),
            $this->getQuery(),
            $fragment
        ));
    }
    public function _toString(){
        return $this->buildUrl(
            $this->getScheme(),
            $this->getUserInfo(),
            $this->getHost(),
            $this->getPort(),
            $this->getPath(),
            $this->getQuery(),
            $this->getFragment()
        );
    }
}
