<?php

namespace PhpRouter;

class Response
{
    public const OK_DEFAULT = 200;
    public const OK_CREATED = 201;
    public const OK_ACCEPTED = 202;
    public const OK_NO_CONTENT = 204;
    public const WARNING_BAD_REQUEST = 400;
    public const WARNING_UNAUTHORIZED = 401;
    public const WARNING_FORBIDDEN = 403;
    public const WARNING_NOT_FOUND = 404;
    public const WARNING_METHOD_NOT_ALLOWED = 405;
    public const WARNING_CONFLICT = 409;
    public const WARNING_LOCKED = 423;
    public const FATAL_INTERNAL_ERROR = 500;

    public readonly int $statusCode;
    public readonly null|string $body;
    public readonly null|array $headers;

    public static function oK(array $body, null|array $headers): self
    {
        return new self (self::OK_DEFAULT, http_build_query($body), $headers);
    }

    public static function oKJson(array $body, null|array $headers): self
    {
        if (!$headers) {
            $headers = [];
        }

        $headers['Content-Type'] = 'application/json';

        return new self (self::OK_DEFAULT, json_encode($body), $headers);
    }

    public static function oKNoContent(null|array $headers): self
    {
        return new self (self::OK_NO_CONTENT, null, $headers);
    }

    public static function errorJson(array $body, null|array $headers): self
    {
        if (!$headers) {
            $headers = [];
        }

        $headers['Content-Type'] = 'application/json';

        return new self (self::OK_DEFAULT, json_encode($body), $headers);
    }

    public function __construct(int $statusCode, null|string $body, null|array $headers)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function Respond()
    {
        if ($this->headers) {
            foreach($this->headers as $key => $value){
                header("$key: $value");
            }
        }

        http_response_code($this->statusCode);

        if ($this->body) {
            die($this->body);
        }

        die();
    }
}