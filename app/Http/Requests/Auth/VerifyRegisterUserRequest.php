<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRegisterUserRequest extends FormRequest
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
            'name'=>['required','string','max:50'],
            'phone_number'=>['required','phone'],
            'code'=>['required','numeric','min_digits:6','max_digits:6'],
            'latitude'=>['nullable','string'],
            'longitude'=>['nullable','string'],
        ];
    }
}
