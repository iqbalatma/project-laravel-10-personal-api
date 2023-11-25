<?php

namespace App\Exceptions;

use App\Http\Controllers\APIResponse;
use App\Services\ResponseCode;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Iqbalatma\LaravelJwtAuthentication\Exceptions\InvalidActionException;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;
use Iqbalatma\LaravelUtils\Exceptions\DumpAPIException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        AuthenticationException::class,
        EmptyDataException::class,
        DumpAPIException::class
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

            if ($e instanceof HttpExceptionInterface) {
                $httpCode = $e->getStatusCode();
            }

            if (str_starts_with($httpCode, "5")) {
                $rc = ResponseCode::ERR_INTERNAL_SERVER_ERROR();
            } elseif (str_starts_with($httpCode, "4")) {
                $rc = ResponseCode::ERR_BAD_REQUEST();
            } else {
                $rc = ResponseCode::ERR_UNKNOWN();
            }

            $response = [
                "rc" => $rc->name,
                "message" => config("app.env") === "production" ? "Something went wrong" : $e->getMessage(),
                "timestamp" => Carbon::now(),
                "payload" => null,
            ];

            if (config("app.env") !== "production") {
                $response["exception"] = [
                    "name" => get_class($e),
                    "message" => $e->getMessage(),
                    "http_code" => $httpCode,
                    "code" => $e->getCode(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                    "trace" => $e->getTrace(),
                ];
            }

            return response()->json($response, $httpCode ?? $rc->httpCode);
        });
    }
}
