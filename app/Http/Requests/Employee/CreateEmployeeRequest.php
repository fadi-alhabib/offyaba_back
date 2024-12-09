<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'phone_number' =>  ['required', 'string', 'phone', 'unique:employees'],
            'store_id' => ['required', 'integer', 'exists:stores,id'],
            'name'=>['required','string','max:50'],
        ];
    }
}
