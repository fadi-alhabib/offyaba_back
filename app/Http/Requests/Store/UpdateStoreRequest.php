<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
            'name' => ['string', 'max:50'],
            'image' => ['required','image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
            'address' => ['string'],
            'latitude' => ['numeric', 'between:-90,90'],
            'longitude' => ['numeric', 'between:-180,180'],
            'discount' => ['numeric', 'between:0,100'],
            'section_id' => ['integer', 'exists:sections,id'],
            'work_hours' => ['array'],
            'work_hours.*.week_day' => ['required','integer', 'distinct', 'between:1,7'],
            'work_hours.*.start_hour' => ['required', 'date_format:H:i'],
            'work_hours.*.end_hour' => ['required', 'date_format:H:i', 'after:work_hours.*.start_hour']
        ];
    }
}
