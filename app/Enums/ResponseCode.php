<?php

namespace App\Enums;

use Symfony\Component\HttpFoundation\Response;

enum ResponseCode {
    case SUCCESS;
    case ERR_UNAUTHENTICATED;
    case ERR_FORBIDDEN;
    case ERR_ENTITY_NOT_FOUND;
    case ERR_INTERNAL_SERVER_ERROR;
    case ERR_BAD_REQUEST;
    case ERR_UNKNOWN;

    public function httpCode(): int
    {
        return match ($this) {
            self::SUCCESS => Response::HTTP_OK,
            self::ERR_UNAUTHENTICATED => Response::HTTP_UNAUTHORIZED,
            self::ERR_ENTITY_NOT_FOUND => Response::HTTP_NOT_FOUND,
            self::ERR_FORBIDDEN => Response::HTTP_FORBIDDEN,
            self::ERR_INTERNAL_SERVER_ERROR, self::ERR_UNKNOWN => Response::HTTP_INTERNAL_SERVER_ERROR,
            self::ERR_BAD_REQUEST => Response::HTTP_BAD_REQUEST,

            default => Response::HTTP_BAD_REQUEST
        };
    }
}
