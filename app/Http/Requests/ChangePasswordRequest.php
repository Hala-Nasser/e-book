<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'password' => 'required|string|current-password:' . 'admin', //current-password: guard name (to check that the current password valus is correct)
            'new_password' => 'required|string|min:6',
            'confirm_new_password' => 'required|same:new_password'
        ];
    }

    public function getData(){
        $data=$this->validated();

        return $data;
    }
}
