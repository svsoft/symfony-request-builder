<?php

declare(strict_types=1);

namespace Svsoft\SymfonyRequestBuilder;

final class RequestParams
{
    private array $params = [];

    public function add(string|int $name, mixed $value): void
    {
        if (isset($this->params[$name])) {
            throw new \InvalidArgumentException(sprintf('param %s already set', $name));
        }

        $this->params[$name] = $value;
    }

    public function addParams(array $params): void
    {
        foreach ($params as $name => $value) {
            $this->add($name, $value);
        }
    }

    public function toArray(): array
    {
        return $this->params;
    }

    public function isEmpty(): bool
    {
        return empty($this->params);
    }
}
