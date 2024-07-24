<?php

namespace Svsoft\SymfonyRequestBuilder;

interface CreateBuilderInterface
{
    public function createBuilder(): RequestBuilder;
}