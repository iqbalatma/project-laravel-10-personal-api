<?php

namespace App\Exceptions;

use App\Enums\ResponseCode;
use App\Traits\APIResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use APIResponse;

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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->remappingException();

    }


    /**
     * @return void
     */
    public function remappingException(): void
    {

        $this->renderable(function (AuthenticationException $e) {
            return $this->apiResponse(
                null,
                "Unauthentication exception",
                ResponseCode::ERR_UNAUTHENTICATED,
                $e
            );
        });

        $this->renderable(function (EmptyDataException $e) {
            return $this->apiResponse(
                null,
                $e->getMessage(),
                ResponseCode::ERR_ENTITY_NOT_FOUND,
                $e
            );
        });

        $this->renderable(function (Throwable|\Exception $e) {
            return $this->apiResponse(
                message: config("app.env") === "production" ? "Something went wrong" : $e->getMessage(),
                responseCode: ResponseCode::ERR_INTERNAL_SERVER_ERROR,
                exception: $e
            );
        });
    }
}
