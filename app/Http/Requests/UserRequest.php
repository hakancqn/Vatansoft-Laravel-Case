<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->is('user/insert')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ];
        }

        if ($this->is('user/update/*')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
            ];
        }

        if ($this->is('user/updatepw/*')) {
            return [
                'oldpw' => 'required|string|min:8',
                'password' => 'required|string|min:8',
            ];
        }

        return [];
    }
}