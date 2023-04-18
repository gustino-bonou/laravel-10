<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:6', 'regex:/^[A-Za-z]+$/'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'regex:/^[A-Z0-9a-z]+$/'],
            'password2' => ['required', 'min:8',]
        ];
    }
}
