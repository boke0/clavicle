<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\ServerRequestFactoryInterface;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\StreamFactoryInterface;

class ServerRequestFactory extends ServerRequestFactory{
    public function __construct(
        StreamFactoryInterface $streamFactory=new StreamFactory(),
        $version="1.1"
    ){
        $this->streamFactory=$streamFactory;
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
