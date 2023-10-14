<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DumpAPIException extends Exception
{
    public function __construct(public mixed $data) {    }

    #Post
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([$this->data]);
    }
}
