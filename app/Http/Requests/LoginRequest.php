<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

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
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string',
            'remember' => 'required|boolean'
        ];
    }

    public function loginInfo(): array {
        $data = $this->validated();
       return [
        'email' => $data['email'],
        'password' => $data['password'],
        'remember' => $data['remember']
       ];
    }
}
