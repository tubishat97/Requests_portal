<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|unique:customers',
            'password' => 'required|min:6',
            'fullname' => 'nullable',
            'rpassword' => 'required|same:password',
        ];

        return $rules;
    }
}
