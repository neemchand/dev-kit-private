<?php

namespace App\ValueObjects\Admin;

use App\Enums\NotificationEnum;

readonly class NotificationVO
{
    public function __construct(
        public NotificationEnum $type,
        public string $title,
        public string $description = ''
    ) {
    }
}
