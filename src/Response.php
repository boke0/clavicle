<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface{
    private const REASONS=[
        100=>"Continue",
        101=>"Switching Protocols",
        102=>"Processing",
        200=>"OK",
        201=>"Created",
        202=>"Accepted",
        203=>"Non-Authoritative Information",
        204=>"No Content",
        205=>"Reset Content",
        206=>"Partial Content",
        207=>"Multi-status",
        208=>"Already Reported",
        300=>"Multiple Choices",
        301=>"Moved Permanently",
        302=>"Found",
        303=>"See Other",
        304=>"Not Modified",
        305=>"Use Proxy",
        306=>"Switch Proxy",
        307=>"Temporary Redirect",
        400=>"Bad Request",
        401=>"Unauthorized",
        402=>"Payment Required",
        403=>"Forbidden",
        404=>"Not Found",
        405=>"Method Not Allowed",
        406=>"Not Acceptable",
        407=>"Proxy Authenticated Required",
        408=>"Request Time-out",
        409=>"Conflict",
        410=>"Gone",
        411=>"Length Required",
        412=>"Precondition Failed",
        413=>"Request Entity Too Large",
        414=>"Request-URI Too Large",
        415=>"Unsupported Media Type",
        416=>"Requested range not satisfiable",
        417=>"Expectation Failed",
        418=>"I'm a teapot",
        422=>"Unprocessable Entity",
        423=>"Locked",
        424=>"Failed Dependency",
        425=>"Unordered Collection",
        426=>"Upgrade Required",
        428=>"Precondition Required",
        429=>"Too Many Requests",
        431=>"Request Header Fields Too Large",
        451=>"Unavailable For Legal Reasons",
        500=>"Internal Server Error",
        501=>"Not Implemented",
        502=>"Bad Gateway",
        503=>"Service Unavailable",
        504=>"Gateway Time-out",
        505=>"HTTP Version not supported",
        506=>"Variant Also Negotiates",
        507=>"Insufficient Storage",
        508=>"Loop Detected ",
        511=>"Network Authentication Required"
    ];
    public function __construct(
        $version,
        $status,
        $headers,
        StreamInterface $body,
        $reason=NULL
    ){
        $this->version=$version;
        $this->status=($status instanceof integer)?$status:intval($status);
        $this->reason=isset($reason)?$reason:self::REASONS[$this->status];
        $this->headers=array();
        foreach($headers as $name=>$value){
            $this->headers[$name]=is_array($value)?$value:explode(",",$value);
        }
        $this->body=$body;
    }
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
    public function getStatusCode(){
        return $this->status;
    }
    public function withStatus($code,$reason=""){
        $response=clone $this;
        $response->status=$code;
        if($reason=="") $reason=self::REASONS[$code];
        $response->reason=$reason;
        return $response;
    }
    public function getReasonPhrase(){
        retun $this->reason;
    }
}

