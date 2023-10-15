<?php

namespace App\Enums;

use Symfony\Component\HttpFoundation\Response;

enum ResponseCode {
    case SUCCESS;
    case ERR_UNAUTHENTICATED;
    case ERR_ENTITY_NOT_FOUND;
    case ERR_INTERNAL_SERVER_ERROR;

    public function httpCode(): int
    {
        return match ($this) {
            self::SUCCESS => Response::HTTP_OK,
            self::ERR_UNAUTHENTICATED => Response::HTTP_UNAUTHORIZED,
            self::ERR_ENTITY_NOT_FOUND => Response::HTTP_NOT_FOUND,
            self::ERR_INTERNAL_SERVER_ERROR => Response::HTTP_INTERNAL_SERVER_ERROR,

            default => Response::HTTP_BAD_REQUEST
        };
    }
}
