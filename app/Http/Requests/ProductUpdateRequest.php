<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            "id" => ["required" , "exists:products,id"],
            "name" => ["nullable","string", "min:3"],
            "description" => ["nullable","string", "min:3"],
            "price" => ["nullable","numeric", "gt:0"],
            "image_path" => ["nullable","string"]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image_path.required' => 'The image is required.',
        ];
    }

}
