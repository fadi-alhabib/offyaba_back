<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'phone_number'=>['regex:/^0([0-9]+)$/','min_digits:10','max_digits:10','numeric','unique:users'],
            'name'=>['string','max:50'],
            'latitude'=>['nullable','string'],
            'longitude'=>['nullable','string']
        ];
    }
}
