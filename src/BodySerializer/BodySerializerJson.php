<?php

namespace Svsoft\SymfonyRequestBuilder\BodySerializer;

use Symfony\Component\HttpClient\HttpOptions;

final class BodySerializerJson implements BodySerializerInterface
{
    /**
     * @param array<string|array> $bodyParams
     */
    public function apply(HttpOptions $httpOptions, array $bodyParams): void
    {
        $httpOptions->setJson($bodyParams);
    }
}
