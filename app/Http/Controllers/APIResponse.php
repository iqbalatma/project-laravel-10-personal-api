<?php

namespace App\Http\Controllers;

use App\Enums\ResponseCode;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Log;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;
use Symfony\Component\HttpFoundation\Response;

class APIResponse implements Responsable
{
    protected array $baseFormat;

    protected const PAYLOAD_WRAPPER = "payload";

    public function __construct(
        protected JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null $data,
        protected ?string                                                                                   $message,
        protected ResponseCode                                                                              $responseCode,
        \Error|\Exception|\Throwable|null                                                                   $error = null
    )
    {
        $this->baseFormat = [
            "code" => $this->getResponseCode()->name,
            "message" => $this->getMessage(),
            "timestamp" => now(),
            "payload" => null
        ];

        if (($error instanceof \Throwable) && config("app.env") !== "production" && config("app.debug") === true) {
            $this->baseFormat["exception"] = [
                "message" => $error->getMessage(),
                "file" => $error->getFile(),
                "line" => $error->getLine(),
                "code" => $error->getCode(),
                "trace" => $error->getTrace(),
            ];
        }
    }

    /**
     * @return ResponseCode
     */
    protected function getResponseCode(): ResponseCode
    {
        return $this->responseCode;
    }


    /**
     * @return JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null
     */
    protected function getData(): JsonResource|ResourceCollection|Arrayable|LengthAwarePaginator|CursorPaginator|array|null
    {
        return $this->data;
    }

    /**
     * @return string
     */
    protected function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    protected function getHttpCode(): int
    {
        return $this->getResponseCode()->httpCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR;
    }


    /**
     * @return array
     */
    protected function getBaseFormat(): array
    {
        return $this->baseFormat;
    }

    /**
     * @return array
     */
    private function getFormattedResponse(): array
    {
        if ($this->getData() instanceof Paginator) {
            return array_merge($this->getBaseFormat(), [self::PAYLOAD_WRAPPER => $this->getData()->toArray()]);
        }

        if ($this->getData() instanceof Arrayable) {
            return array_merge($this->getBaseFormat(), [self::PAYLOAD_WRAPPER => [JsonResource::$wrap => $this->getData()->toArray()]]);
        }

        if (($this->getData()?->resource ?? null) instanceof AbstractPaginator) {
            return array_merge($this->getBaseFormat(), [
                self::PAYLOAD_WRAPPER => array_merge(
                    $this->getData()->resource->toArray(),
                    [JsonResource::$wrap => $this->getData()]
                )
            ]);
        }

        return array_merge($this->getBaseFormat(), [
            self::PAYLOAD_WRAPPER => is_null($this->data) ? $this->data : [JsonResource::$wrap => $this->data]
        ]);
    }


    /**
     * @param $request
     * @return Response
     */
    public function toResponse($request): Response
    {
        return response()->json($this->getFormattedResponse(), $this->getHttpCode());
    }
}
