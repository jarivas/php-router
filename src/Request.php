<?php

namespace PhpRouter;

class Request
{
    public readonly array $headers;
    public readonly array $pathParameters;
    public readonly array $queryParameters;
    public readonly array $body;

    public function __construct(array $headers, array $pathParameters, array $queryParameters, array $body)
    {
        $this->headers = $headers;
        $this->pathParameters = $pathParameters;
        $this->queryParameters = $queryParameters;
        $this->body = $body;
    }
}