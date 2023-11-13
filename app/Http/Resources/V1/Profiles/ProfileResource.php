<?php

namespace App\Http\Resources\V1\Profiles;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "fullname" => $this->fullname,
            "email" => $this->email,
            "phone_number" => $this->phone_number,
            "address" => $this->profile?->address,
            "gender" => $this->profile?->gender,
            "avatar" => $this->profile?->avatar,
            "birth_place" => $this->profile?->birth_place,
            "birth_date" => $this->profile?->birth_date,
            "created_at" => $this->created_at,
        ];
    }
}
