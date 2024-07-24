<?php

namespace Svsoft\SymfonyRequestBuilder\Body;

use Symfony\Component\HttpClient\HttpOptions;

interface BodyLoaderInterface
{
    public function apply(HttpOptions $httpOptions, array $bodyParams): void;
}