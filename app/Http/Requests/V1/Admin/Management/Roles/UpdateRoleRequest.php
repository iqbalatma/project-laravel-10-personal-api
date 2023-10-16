<?php

namespace App\Http\Requests\V1\Admin\Management\Roles;

use App\Enums\Table;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            "name" => "max:128",
            "guard_name" => "max:128",
            "permission_ids" => "nullable|array",
            "permission_ids.*" => "exists:".Table::PERMISSIONS->value.",id",
        ];
    }
}
