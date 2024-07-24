<?php

declare(strict_types=1);

namespace Svsoft\SymfonyRequestBuilder;

final class RequestParams
{
    /**
     * @var array<string, mixed>
     */
    private array $params = [];

    public function set(string $name, mixed $value): void
    {
        $this->params[$name] = $value;
    }

    /**
     * @param array<string, mixed> $params
     */
    public function setParams(array $params): void
    {
        $this->params = [];
        foreach ($params as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * @return array<string|int, mixed>
     */
    public function toArray(): array
    {
        return $this->params;
    }

    public function isEmpty(): bool
    {
        return empty($this->params);
    }
}
