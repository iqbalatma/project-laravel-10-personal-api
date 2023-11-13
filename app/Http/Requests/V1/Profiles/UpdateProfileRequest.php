<?php

namespace App\Http\Requests\V1\Profiles;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "firstname" => "max:128",
            "lastname" => "max:128",
            "profile" => "array",
            "profile.address" => "max:1000",
            "profile.gender" => [Rule::in(Gender::values())],
            "profile.birth_place" => "max:128",
            "profile.birth_date" => "date_format:Y-m-d ",
        ];
    }
}
