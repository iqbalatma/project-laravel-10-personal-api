<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

class ResponseCode
{
    public const SUCCESS = "SUCCESS";
    public const ERR_UNAUTHENTICATED = "ERR_UNAUTHENTICATED";
    public const ERR_VALIDATION = "ERR_VALIDATION";
    public const ERR_FORBIDDEN = "ERR_FORBIDDEN";
    public const ERR_ENTITY_NOT_FOUND = "ERR_ENTITY_NOT_FOUND";
    public const ERR_INTERNAL_SERVER_ERROR = "ERR_INTERNAL_SERVER_ERROR";
    public const ERR_BAD_REQUEST = "ERR_BAD_REQUEST";
    public const ERR_UNKNOWN = "ERR_UNKNOWN";

//    public function httpCode(): int
//    {
//        return match ($this) {
//            self::SUCCESS => Response::HTTP_OK,
//            self::ERR_UNAUTHENTICATED => Response::HTTP_UNAUTHORIZED,
//            self::ERR_VALIDATION => Response::HTTP_UNPROCESSABLE_ENTITY,
//            self::ERR_ENTITY_NOT_FOUND => Response::HTTP_NOT_FOUND,
//            self::ERR_FORBIDDEN => Response::HTTP_FORBIDDEN,
//            self::ERR_INTERNAL_SERVER_ERROR, self::ERR_UNKNOWN => Response::HTTP_INTERNAL_SERVER_ERROR,
//            self::ERR_BAD_REQUEST => Response::HTTP_BAD_REQUEST,
//
//            default => Response::HTTP_BAD_REQUEST
//        };
//    }
}
