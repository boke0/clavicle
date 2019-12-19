<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\RequestFactoryInterface;
use \Psr\Http\Message\StreamFactoryInterface;

class RequestFactory implements RequestFactoryInterface{
    public function __construct(
        $version="1.1"
    ){
        $this->version=$version;
        $this->streamFactory=new StreamFactory();
    }
    public function createRequest(string $method,$uri): RequestInterface{
        $body=$this->streamFactory->createStreamFromFile("php://input","r");
        return new Request(
            $this->version,
            $method,
            $uri,
            [],
            $body
        );
    }
}
