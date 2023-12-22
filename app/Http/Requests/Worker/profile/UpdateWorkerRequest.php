<?php

namespace App\Http\Requests\Worker\profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateWorkerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|string|max:100|unique:workers,email,' . auth()->guard('worker')->id(),
            'password' => 'nullable|string|min:6',
            'phone' => 'required|string|max:17',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg',
            'location' => 'required|string|min:5'
        ];
    }
}
