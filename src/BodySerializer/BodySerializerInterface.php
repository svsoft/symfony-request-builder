<?php

namespace Svsoft\SymfonyRequestBuilder\BodySerializer;

use Symfony\Component\HttpClient\HttpOptions;

interface BodySerializerInterface
{
    /**
     * @param array<string|array> $bodyParams
     */
    public function apply(HttpOptions $httpOptions, array $bodyParams): void;
}
