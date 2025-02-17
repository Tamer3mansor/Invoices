<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "product_name" => 'required', // Correct table and column
            "section_id" => ["required", "exists:sections,id"], // Ensures `section_id` exists in `sections`
        ];
    }
}

