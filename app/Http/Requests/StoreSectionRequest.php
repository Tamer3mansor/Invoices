<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
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
            'section_name' => 'required|unique:sections|max:255'
        ];

    }
    public function messages(): array
    {
        return [
            'section_name.required' => 'A section_name is required',
            'section_name.unique' => 'القسم موجود مره ياعم',
        ];
    }
}
