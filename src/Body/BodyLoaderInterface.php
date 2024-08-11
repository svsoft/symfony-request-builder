<?php

namespace Svsoft\SymfonyRequestBuilder\Body;

use Symfony\Component\HttpClient\HttpOptions;

interface BodyLoaderInterface
{
    /**
     * @param array<string|array> $bodyParams
     */
    public function apply(HttpOptions $httpOptions, array $bodyParams): void;
}