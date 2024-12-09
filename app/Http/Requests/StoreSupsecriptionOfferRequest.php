<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupsecriptionOfferRequest extends FormRequest
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
            'period' => ['required', 'integer', 'between:1,12'],
            'cost' => ['required', 'numeric'],
            'discount' => ['required', 'numeric', 'between:0,100'],
            'number_of_usage' => ['required', 'integer']
        ];
    }
}
