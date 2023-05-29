<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EqualConfirmPassword;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "login" => ["required", "string", "min:6", "max:12"],
            "password" => ["required", "string", "min:6", "max:12"],
            "email" => ["required", "email", "min:4"],
            "confirm_password" => ["required",  new EqualConfirmPassword()]
        ];
    }

    public function messages()
    {
        return [
            "login.required" => "Login is required field",
            "login.min" => "Login must contains at least 6 symbols",
            "login.max" => "Login must contains no more then 12 symbols",
            "password.required" => "Password is required field",
            "password.min" => "Password must contains at least 6 symbols",
            "password.max" => "Password must contains no more then 12 symbols",
            "email.required" => "Email is required field",
            "email.email" => "Incorrect format for email field"
        ];
    }
}
