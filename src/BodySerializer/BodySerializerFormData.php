<?php

namespace Svsoft\SymfonyRequestBuilder\BodySerializer;

use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

final class BodySerializerFormData implements BodySerializerInterface
{
    /**
     * @param array<string|array|int> $bodyParams
     */
    public function apply(HttpOptions $httpOptions, array $bodyParams): void
    {
        $this->normalize($bodyParams);

        $formData = new FormDataPart($bodyParams);
        $httpOptions->setBody($formData->bodyToString());
        $httpOptions->setHeaders($formData->getPreparedHeaders()->toArray());
    }

    private function normalize(array &$params): void
    {
        foreach ($params as &$value) {
            if (is_array($value)) {
                $this->normalize($value);

                return;
            }
            if (!is_string($value)) {
                $value = (string) $value;
            }
        }
    }
}
