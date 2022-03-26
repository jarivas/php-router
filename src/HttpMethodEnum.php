<?php

namespace PhpRouter;

enum HttpMethodEnum: string
{
    case Get = 'GET';
    case Post = 'POST';
    case Put = 'PUT';
    case Delete = 'DELETE';
    case Options = 'OPTIONS';
    case Patch = 'PATCH';
}