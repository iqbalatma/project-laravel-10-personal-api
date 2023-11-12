<?php

namespace App\Http\Resources\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class AuthenticateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this["user"];
        return [
            "id" => $user->id,
            "firstname" => $user->firstname,
            "lastname" => $user->lastname,
            "fullname" => $user->fullname,
            "email" => $user->email,
            "token" => $this["token"]
        ];
    }
}
