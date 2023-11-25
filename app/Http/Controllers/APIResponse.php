<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;

class APIResponse extends \Iqbalatma\LaravelUtils\APIResponse
{
    protected string $metaKeyName = "pagination";

    /**
     * @return array
     */
    protected function getFormattedResponse(): array
    {
        if ($this->getData() instanceof Paginator) {
            $meta = $this->getData()->toArray();
            unset($meta["data"]);

            return array_merge($this->getBaseFormat(), [
                self::PAYLOAD_WRAPPER => array_merge(
                    [JsonResource::$wrap => $this->getData()->toArray()["data"]],
                    [$this->metaKeyName => $meta],
                )
            ]);
        }


        if (($this->getData()?->resource ?? null) instanceof AbstractPaginator) {
            $meta = $this->getData()->resource->toArray();
            unset($meta["data"]);

            return array_merge($this->getBaseFormat(), [
                self::PAYLOAD_WRAPPER => array_merge(
                    [JsonResource::$wrap => $this->getData()],
                    [$this->metaKeyName => $meta],
                )
            ]);
        }

        return parent::getFormattedResponse();
    }
}
