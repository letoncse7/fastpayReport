<?php

namespace App\Traits;
use App\Http\Controllers\Traits\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

trait ApiValidationResponseHelperTrait
{
    use ApiResponseTrait;

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->invalidResponse($validator->errors()->all(), 422)
        );
    }
}