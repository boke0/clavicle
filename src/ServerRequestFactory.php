<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\ServerRequestFactoryInterface;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\StreamFactoryInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface{
    public function __construct(
        $version="1.1"
    ){
        $this->streamFactory=new StreamFactory();
        $this->version=$version;
    }
    public function createServerRequest(string $method,$uri,array $serverParams=[]): ServerRequestInterface{
        $body=$this->streamFactory->createStreamFromFile("php://input","r");
        return new ServerRequest(
            $this->version,
            $method,
            $uri,
            [],
            $body,
            $serverParams
        );
    }
}
