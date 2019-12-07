<?php

namespace Boke0\Clavicle;
use \Psr\Http\Message\UriFactoryInterface;
use \Psr\Http\Message\UriInterface;

class UriFactory implements UriFactoryInterface{
    public function createUri(string $uri=""): UriInterface{
        $parsed=parse_url($uri);
        if(!$parsed){
            throw new \InvalidArgumentException("Given uri cannot be parsed.");
        }
        $user=isset($parsed["pass"])?"{$parsed["user"]}:{$parsed["pass"]}":$parsed["user"];
        return new Uri(
            $parsed["scheme"],
            $user,
            $parsed["host"],
            $parsed["port"],
            $parsed["path"],
            $parsed["query"],
            $parsed["fragment"]
        );
    }
}
