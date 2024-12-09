<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class FilterClothingItemRequest extends FormRequest
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
            'store_id'=>['integer','exists:stores,id'],
            'min_price'=>['decimal:0,2','min:0','max:99999999.99','required_with:max_price'],
            'max_price'=>['decimal:0,2','min:0','max:99999999.99','gte:min_price'],
            'type_id'=>['integer','exists:clothing_types,id'],
            'target_group'=>['in:Men,Women,Children,BB'],
        ];
    }
}
