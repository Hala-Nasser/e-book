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
            'sub_category_id' => 'required|integer',
            'publish_date' => 'required',
            'description' => 'required|min:3|max:100',
            'price' => 'required|min:0',
            'image' => 'required|image',
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
