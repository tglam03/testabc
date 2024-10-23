<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name'        => ['required', 'max:255', 'string'],
            'email'       => ['required', 'max:255', Rule::unique('employees')],
            'phone'       => ['required', 'max:20',  Rule::unique('employees')],
            'address'     => ['nullable',],
            'image'     => ['nullable', 'max:2048', 'image'],
            'is_active'  => ['nullable', Rule::in(0, 1)],
        ];
    }
}
