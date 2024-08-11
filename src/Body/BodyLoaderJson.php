<?php

namespace Svsoft\SymfonyRequestBuilder\Body;

use Symfony\Component\HttpClient\HttpOptions;

class BodyLoaderJson implements BodyLoaderInterface
{
    /**
     * @param array<string|array> $bodyParams
     */
    public function apply(HttpOptions $httpOptions, array $bodyParams): void
    {
        $httpOptions->setJson($bodyParams);
    }
}