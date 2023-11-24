<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Iqbalatma\LaravelJwtAuthentication\Exceptions\InvalidActionException;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;
use Iqbalatma\LaravelUtils\APIResponse;
use Iqbalatma\LaravelUtils\ResponseCode;
use Iqbalatma\LaravelUtils\Traits\APIResponseTrait;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use APIResponseTrait;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (\Illuminate\Validation\ValidationException $e) {
            if (request()->expectsJson()) {
                return new APIResponse(
                    null,
                    $e->getMessage(),
                    ResponseCode::ERR_VALIDATION(),
                    errors: $e->errors(),
                    exception: $e
                );
            }
        });
        $this->renderable(function (EmptyDataException $e) {
            if (request()->expectsJson()) {
                return new APIResponse(
                    null,
                    $e->getMessage(),
                    ResponseCode::ERR_ENTITY_NOT_FOUND(),
                    exception: $e
                );
            }
        });

        $this->renderable(function (AuthenticationException $e) {
            if (request()->expectsJson()) {
                return new APIResponse(
                    null,
                    "You are unauthenticated to access this resource",
                    ResponseCode::ERR_UNAUTHENTICATED(),
                    exception: $e
                );
            }
        });
        $this->renderable(function (NotFoundHttpException $e) {
            if (request()->expectsJson()) {
                return new APIResponse(
                    null,
                    "You resource the you specified are not found",
                    ResponseCode::ERR_ROUTE_NOT_FOUND(),
                    exception: $e
                );
            }
        });

        $this->renderable(function (AccessDeniedHttpException $e) {
            if (request()->expectsJson()) {
                return new APIResponse(
                    null,
                    "You are unauthorized to access this resource",
                    ResponseCode::ERR_FORBIDDEN(),
                    exception: $e
                );
            }
        });

        $this->renderable(function (InvalidActionException $e) {
            if (request()->expectsJson()) {
                return new APIResponse(
                    null,
                    $e->getMessage(),
                    ResponseCode::ERR_FORBIDDEN(),
                    exception: $e
                );
            }
        });

        $this->renderable(function (Throwable|Exception|Error $e) {
            $httpCode = null;

            if ($e instanceof HttpExceptionInterface){
                $httpCode = $e->getStatusCode();
            }

            if (str_starts_with($httpCode, "5")) {
                $rc = ResponseCode::ERR_INTERNAL_SERVER_ERROR();
            } elseif (str_starts_with($httpCode, "4")) {
                $rc = ResponseCode::ERR_BAD_REQUEST();
            } else {
                $rc = ResponseCode::ERR_UNKNOWN();
            }

            return response()->json([
                "code" => $rc->name,
                "message" => config("app.env") === "production" ? "Something went wrong" : $e->getMessage(),
                "timestamp"=> Carbon::now(),
                "payload" =>null,
                "exception" => [
                    "name" => get_class($e),
                    "message" => $e->getMessage(),
                    "http_code" => $httpCode,
                    "code" => $e->getCode(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                    "trace" => $e->getTrace(),
                ]
            ], $httpCode ?? $rc->httpCode);
        });
    }
}
