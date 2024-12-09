<?php

namespace App\Http\Requests\Item\Clothing;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClothingItemRequest extends FormRequest
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
            'name' => ['string'],
            'price' => ['decimal:0,2', 'min:0'],
            'discount' => ['decimal:0,2', 'min:0', 'max:100'],
            'type_id' => ['integer', 'exists:clothing_types,id'],
            'target_group' => ['in:Men,Women,Children,BB'],
            'sizes' => ['array'],
            'sizes.*' => ['required_with:sizes', 'string', 'in:XS,S,M,L,XL,XXL,3XL,4XL'],
            'colors' => ['array'],
            'colors.*' => ['required_with:colors', 'string'],
            'material' => ['nullable', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
