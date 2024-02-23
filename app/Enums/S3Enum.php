<?php

namespace App\Enums;

enum S3Enum: string
{
    case PUT = 'PutObject';
    case GET = 'GetObject';
    case POST = 'PostObject';
}
