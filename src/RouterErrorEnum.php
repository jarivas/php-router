<?php

namespace PhpRouter;

enum RouterErrorEnum: string
{
    case INVALID_HTTP_METHOD = 'phprouter_invalid_http_method';
    case NO_MATCH = 'phprouter_no_match';
}