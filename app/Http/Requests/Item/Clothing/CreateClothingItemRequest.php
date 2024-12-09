<?php

namespace App\Http\Requests\Item\Clothing;

use Illuminate\Foundation\Http\FormRequest;

class CreateClothingItemRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'price' => ['required', 'decimal:0,2', 'min:0','max:99999999.99'],
            'discount' => ['required', 'decimal:0,2', 'min:0', 'max:100'],
            'type_id' => ['required', 'integer', 'exists:clothing_types,id'],
            'target_group' => ['required', 'in:Men,Women,Children,BB'],
            'sizes' => ['required', 'array'],
            'sizes.*' => ['required', 'string', 'in:XS,S,M,L,XL,XXL,3XL,4XL'],
            'colors' => ['required', 'array'],
            'colors.*' => ['required', 'string'],
            'material' => ['string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
