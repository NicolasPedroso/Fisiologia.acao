<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'address'  => 'required|string|max:255',
            'phone'    => 'required|regex:/^(\d{2})(\d{4,5})-(\d{4})$/',
            'image'    => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'admin'    => 'required|boolean'
        ];
    }
}
