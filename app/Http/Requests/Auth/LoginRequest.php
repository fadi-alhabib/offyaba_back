<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $type = 'App\Http\Requests\Auth\\' . ucfirst(request('type'));
        $className = $type . 'LoginRequest';
        return (new $className)->rules();
    }

    public function messages(): array
    {
        return [
            'phone_number.phone'=>'الرجاء التأكد من صحة رقم الهاتف',
            'phone_number.exists'=>'أنت لست مخول للدخول'
        ];
    }
}
