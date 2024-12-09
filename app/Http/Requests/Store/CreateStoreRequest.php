<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class CreateStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'image' => ['required','image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
            'address' => ['required', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'discount' => ['required', 'numeric', 'between:0,100'],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'work_hours' => ['array'],
            'work_hours.*.week_day' => ['required','integer', 'distinct', 'between:1,7'],
            'work_hours.*.start_hour' => ['required', 'date_format:H:i'],
            'work_hours.*.end_hour' => ['required', 'date_format:H:i', 'after:work_hours.*.start_hour']
        ];
    }
}
