<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Iqbalatma\LaravelUtils\Traits\APIResponseTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, APIResponseTrait;
}
