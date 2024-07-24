<?php

namespace Svsoft\SymfonyRequestBuilder\Body;

use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class BodyLoaderFormData implements BodyLoaderInterface
{
    public function apply(HttpOptions $httpOptions, array $bodyParams): void
    {
        $formData = new FormDataPart($bodyParams);
        $httpOptions->setBody($formData->bodyToString());
        $httpOptions->setHeaders($formData->getPreparedHeaders()->toArray());
    }
}
