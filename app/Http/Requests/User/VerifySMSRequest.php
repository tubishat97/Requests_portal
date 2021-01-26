<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'username' => 'required|exists:users,username',
            'verification_code' => 'required',
        ];

        return $rules;
    }
}
