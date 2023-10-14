<?php

namespace App\Enums;

use Symfony\Component\HttpFoundation\Response;

enum ResponseCode {
    case SUCCESS;

    public function httpCode(): int
    {
        return match ($this) {
            self::SUCCESS => Response::HTTP_OK,

            default => Response::HTTP_BAD_REQUEST
        };
    }
}
