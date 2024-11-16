<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCheckoutRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_user'=>'required|integer',
            'total'=>'required|integer',
            'payment_method'=>'required|string',
            'payment_price'=>'required|integer',
            'delivery_method'=>'required|string',
            'delivery_price'=>'required|integer',
            'id_trolley' => 'required|array', // Ensure it's an array
            'id_trolley.*' => 'integer',     // Ensure each element is an integer
        ];
    }
    public function failedValidation(Validator  $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
