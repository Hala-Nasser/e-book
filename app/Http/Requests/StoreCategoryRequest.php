<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'image' => 'required|image',
            'status' => 'required|in:true,false'
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $data['status'] = $data['status'] == 'true';

        if ($this->hasFile('image')) {
            $imageName = time() . "" . '.' . $this->file('image')->getClientOriginalExtension();
            $this->file('image')->storePubliclyAs('Category', $imageName, ['disk' => 'public']);
            $data['image'] = 'Category/' . $imageName;
        }
        return $data;
    }
}
