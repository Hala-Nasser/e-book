<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:30',
            'author_name' => 'required|min:3|max:30',
            'category_id' => 'required|integer',
            'publish_date' => 'required',
            'description' => 'required|min:3|max:100',
            'price' => 'required|min:0',
            'image' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please fill book name',
            'name.min' => 'Book name is too short',
            'name.max' => 'Book name is too long',
            'author_name.required' => 'Please fill author name',
            'author_name.min' => 'Author name is too short',
            'author_name.max' => 'Author name is too long',
            'category_id.required' => 'Please select book category',
            'category_id.integer' => 'ID must be integer',
            'publish_date.required' => 'Please fill publish date',
            'description.required' => 'Please fill book description',
            'description.min' => 'Description is too short',
            'description.max' => 'Description is too long',
            'price.required' => 'Please fill book price',
            'price.min' => 'The minimun price is zero',
            'image.image' => 'Please make sure that you upload image',
            'image.required' => 'Please upload book image'

        ];
    }

    public function getData(){
        $data=$this->validated();

        if ($this->hasFile('image')) {
            $imageName = time() . "" . '.' . $this->file('image')->getClientOriginalExtension();
            $this->file('image')->storePubliclyAs('Book', $imageName, ['disk' => 'public']);
            $data['image'] = 'Book/' . $imageName;
        }

        return $data;
    }

}
