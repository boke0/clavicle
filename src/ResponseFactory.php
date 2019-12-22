<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\ResponseFactoryInterface;
use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\StreamFactoryInterface;

class ResponseFactory implements ResponseFactoryInterface{
    public function __construct(
        StreamFactoryInterface $streamFactory=new StreamFactory(),
        $version="1.1"
    ){
        $this->version=$vesion;
        $this->streamFactory=$streamFactory;
    }
    public function createResponse(int $code=200,string $reason=""): ResponseInterafce{
        $body=$this->streamFactory->createStreamFromFile("php://output","w+");
        return new Response(
            $this->version,
            $code,
            [],
            $body,
            $reason
        );
    }
}

