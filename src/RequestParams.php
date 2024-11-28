<?php

declare(strict_types=1);

namespace Svsoft\SymfonyRequestBuilder;

final class RequestParams
{
    /**
     * @var array<string|int, mixed>
     */
    private array $params = [];

    public function set(string $name, mixed $value): void
    {
        $this->params[$name] = $value;
    }

    /**
     * @param array<string|int, mixed> $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
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
