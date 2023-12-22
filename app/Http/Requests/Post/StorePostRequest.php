<?php

namespace App\Http\Requests\Post;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'price' => 'required|numeric',
            'photo.*' => 'nullable|array|image|mimes:png,jpg,jpeg',
        ];
    }
}
