<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
             'role_id' => 'required|numeric|exists:roles,id'
         ];
     }

     public function getData(){
         $data=$this->validated();

         return $data;
     }
}
