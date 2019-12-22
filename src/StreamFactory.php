<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\StreamFactoryInterface;
use \Psr\Http\Message\StreamInterface;

class StreamFactory implements StreamFactoryInterface{
    public function createStream(string $content=""): StreamInterface{
        $fp=fopen("php://temp","w+");
        $stream=new Stream(fp);
        return $stream->write($content);
    }
    public function createStreamFromFile(string $filename,string $mode="r"): StreamInterface{
        $fp=fopen($filename,$mode);
        return new Stream($fp);
    }
    public function createStreamFromResource($resource): StreamInterface{
        return new Stream($resource);
    }
}
