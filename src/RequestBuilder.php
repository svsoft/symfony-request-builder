<?php

namespace Svsoft\SymfonyRequestBuilder;

use Svsoft\SymfonyRequestBuilder\Body\BodyLoaderInterface;
use Svsoft\SymfonyRequestBuilder\Body\BodyLoaderJson;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class RequestBuilder
{
    private ?float $timeout = null;

    private string $method;
    private RequestParams $queryParams;
    private RequestParams $headers;
    private RequestParams $bodyParams;

    private string $url;

    private BodyLoaderInterface $bodyLoader;

    public function __construct(
        private readonly HttpClientInterface $client
    ) {
        $this->queryParams = new RequestParams();
        $this->headers = new RequestParams();
        $this->bodyParams = new RequestParams();
        $this->bodyLoader = new BodyLoaderJson();
    }

    public function get(string $path): self
    {
        return $this->setMethod('GET')->setUrl($path);
    }

    public function post(string $path): self
    {
        return $this->setMethod('POST')->setUrl($path);
    }

    public function put(string $path): self
    {
        return $this->setMethod('PUT')->setUrl($path);
    }

    public function delete(string $path): self
    {
        return $this->setMethod('DELETE')->setUrl($path);
    }

    public function patch(string $path): self
    {
        return $this->setMethod('PATCH')->setUrl($path);
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function addHeader(string $name, string|int $value): self
    {
        $this->headers->add($name, $value);

        return $this;
    }

    /**
     * Добавляет параметры в запрос, параметры не могут быть перезаписан.
     * @param array<string|int, mixed> $params
     */
    public function addQueryParams(array $params): self
    {
        $this->queryParams->addParams($params);

        return $this;
    }

    /**
     * Добавляет параметры в запрос, параметры не могут быть перезаписан.
     */
    public function addQueryParam(string $name, string|int $value): self
    {
        $this->queryParams->add($name, $value);

        return $this;
    }

    /**
     * Добавляет параметры в боди, параметры не могут быть перезаписан.
     * @param array<string|int, mixed> $params
     */
    public function addBodyParams(array $params): self
    {
        $this->bodyParams->addParams($params);

        return $this;
    }

    public function addBodyParam(string $name, mixed $value): self
    {
        $this->bodyParams->add($name, $value);

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function request(): ResponseInterface
    {
        return $this->client->request($this->method, $this->url, $this->prepareOptions());
    }

    /**
     * @return array<int|string>
     */
    private function prepareOptions(): array
    {
        $options = (new HttpOptions());

        if ($this->timeout !== null) {
            $options->setTimeout($this->timeout);
        }

        $options->setHeaders($this->headers->toArray());

        $bodyOptions = $this->loadBody();

        return [10,'asd'];

        // return array_merge(...array_map(fn (HttpOptions $options) => $options->toArray(), [$options, $bodyOptions]));
    }

    private function loadBody(): HttpOptions
    {
        $options = (new HttpOptions());

        if (!$this->bodyParams->isEmpty()) {
            $this->bodyLoader->apply($options, $this->bodyParams->toArray());
        }

        return $options;
    }

    public function setTimeout(?float $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setBodyLoader(BodyLoaderInterface $bodyLoader): self
    {
        $this->bodyLoader = $bodyLoader;
        return $this;
    }
}
