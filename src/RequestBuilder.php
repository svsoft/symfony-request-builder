<?php

namespace Svsoft\SymfonyRequestBuilder;

use Svsoft\SymfonyRequestBuilder\BodySerializer\BodySerializerInterface;
use Svsoft\SymfonyRequestBuilder\BodySerializer\BodySerializerJson;
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

    private array $options;

    private string $url;

    private BodySerializerInterface $bodySerializer;

    public function __construct(private readonly HttpClientInterface $client)
    {
        $this->queryParams = new RequestParams();
        $this->headers = new RequestParams();
        $this->bodyParams = new RequestParams();
        $this->bodySerializer = new BodySerializerJson();
        $this->options = [];
    }

    public static function create(HttpClientInterface $client): self
    {
        return new self($client);
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

    public function setHeader(string $name, string|int $value): self
    {
        $this->headers->set($name, $value);

        return $this;
    }

    /**
     * @param array<string, mixed> $params
     */
    public function setQueryParams(array $params): self
    {
        $this->queryParams->setParams($params);

        return $this;
    }

    public function setQueryParam(string $name, string|int|array $value): self
    {
        $this->queryParams->set($name, $value);

        return $this;
    }

    /**
     * @param array<string, mixed> $params
     */
    public function setBodyParams(array $params): self
    {
        $this->bodyParams->setParams($params);

        return $this;
    }

    public function setBodyParam(string $name, mixed $value): self
    {
        $this->bodyParams->set($name, $value);

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

    public function setTimeout(?float $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setBodySerializer(BodySerializerInterface $bodySerializer): self
    {
        $this->bodySerializer = $bodySerializer;

        return $this;
    }

    public function setOptions(array $options): RequestBuilder
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array<int|string|array>
     */
    private function prepareOptions(): array
    {
        $options = (new HttpOptions());

        if ($this->timeout !== null) {
            $options->setTimeout($this->timeout);
        }

        if (!empty($this->headers->toArray())) {
            $options->setHeaders($this->headers->toArray());
        }

        if (!$this->queryParams->isEmpty()) {
            $options->setQuery($this->queryParams->toArray());
        }

        $bodyOptions = $this->serializeBody();

        $optionArrays = array_map(
            static fn (HttpOptions $options) => $options->toArray(),
            [$options, $bodyOptions]
        );

        array_unshift($optionArrays, $this->options);

        return array_merge(...$optionArrays);
    }

    private function serializeBody(): HttpOptions
    {
        $options = (new HttpOptions());

        if (!$this->bodyParams->isEmpty()) {
            $this->bodySerializer->apply($options, $this->bodyParams->toArray());
        }

        return $options;
    }
}
