<?php

namespace App\Http\Requests\Order;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStoreRequest extends FormRequest
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
             'client_id' => [
                 'required',
                 'integer',
                 'exists:clients,id',
                 Rule::unique('client_orders')->where(function ($query) {
                     return $query->where('client_id', $this->client_id)
                                  ->where('post_id', $this->post_id);
                 })->ignore($this->route('order')), // Add this line to ignore the current order when updating
             ],
             'post_id' => 'required|integer|exists:posts,id',
         ];
     }

public function messages(): array
{
    return [
        'client_id.unique' => 'The combination of client_id and post_id already exists.',
    ];
}
}
