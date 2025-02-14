<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'max:2048'],
            'images.*' => ['required', 'image', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'colors' => ['nullable'],
            'short_description' => ['required', 'max:255', 'string'],
            'qty' => ['required', 'numeric'],
            'sku' => ['string', 'required', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }
}
