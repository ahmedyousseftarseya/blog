<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class GeneralRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     * @param Validator $validator The validation instance.
     * @throws HttpResponseException The HTTP response exception.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(responseJson(404, $validator->errors()));
    }

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
