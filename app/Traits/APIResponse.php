<?php

namespace App\Traits;

use App\Enums\ResponseCode;
use Error;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\APIResponse as APIResponseData;
use Throwable;

trait APIResponse
{
    protected array $responseMessages;

    /**
     * Use to get response message
     *
     * @param string $context
     * @return string
     */
    public function getResponseMessage(string $context): string
    {
        return $this->responseMessages[$context];
    }

    /**
     * @param JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null $data
     * @param string|null $message
     * @param ResponseCode|null $responseCode
     * @param Error|Exception|Throwable|null $exception
     * @return APIResponseData
     */
    public function apiResponse(
        JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null $data = null,
        ?string                                                                                   $message = null,
        ?ResponseCode                                                                             $responseCode = null,
        Error|Exception|Throwable|null                                                            $exception = null
    ): APIResponseData
    {
        return new APIResponseData($data, $message, $responseCode, $exception);
    }
}
