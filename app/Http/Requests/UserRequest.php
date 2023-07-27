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
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ];
        }

        if ($this->is('user/update/*')) {
            $userId = $this->segment(2);
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $userId,
            ];
        }

        if ($this->is('user/updatepw/*')) {
            return [
                'password' => 'required|string|min:8',
            ];
        }

        return [];
    }
}