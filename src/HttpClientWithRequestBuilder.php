<?php

namespace Svsoft\SymfonyRequestBuilder;

use Symfony\Component\HttpClient\DecoratorTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClientWithRequestBuilder implements HttpClientInterface, CreateBuilderInterface
{
    use DecoratorTrait;

    public function createBuilder(): RequestBuilder
    {
        return new RequestBuilder($this);
    }
}