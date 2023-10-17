<?php

namespace App\Exceptions;

use App\Enums\ResponseCode;
use Error;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;
use Iqbalatma\LaravelUtils\Traits\APIResponseTrait;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
        $this->reportable(function (Throwable $e) {
            //
        });

//        $this->remappingException();

    }


    /**
     * @return void
     */
//    public function remappingException(): void
//    {
//
//        $this->renderable(function (AuthenticationException $e) {
//            return $this->apiResponse(
//                null,
//                "Unauthentication exception",
//                ResponseCode::ERR_UNAUTHENTICATED,
//                $e
//            );
//        });
//
//        $this->renderable(function (EmptyDataException $e) {
//            return $this->apiResponse(
//                null,
//                $e->getMessage(),
//                ResponseCode::ERR_ENTITY_NOT_FOUND,
//                $e
//            );
//        });
//
//        $this->renderable(function (AccessDeniedHttpException $e) {
//            return $this->apiResponse(
//                null,
//                $e->getMessage(),
//                ResponseCode::ERR_FORBIDDEN,
//                $e
//            );
//        });
//
//        $this->renderable(function (UniqueConstraintViolationException $e){
//            return $this->apiResponse(
//                null,
//                "Error unique validation exception",
//                ResponseCode::ERR_VALIDATION,
//                $e
//            );
//        });
//
//
//        $this->renderable(function (Throwable|Exception $e) {
//            return $this->apiResponse(
//                message: config("app.env") === "production" ? "Something went wrong" : $e->getMessage(),
//                exception: $e
//            );
//        });
//    }
}
