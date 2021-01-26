<?php

namespace App\Http\Requests\Customer;

use App\Enums\VerificationTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifySMSRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'required|exists:customers,username',
            'verification_code' => 'required',
        ];

        return $rules;
    }
}
