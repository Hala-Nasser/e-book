<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UpdateCategoryRequest extends FormRequest
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
            'image' => 'nullable|image',
            'status' => 'required|in:true,false'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please fill book name',
            'name.min' => 'Book name is too short',
            'name.max' => 'Book name is too long',
            'image.image' => 'Please make sure that you upload image',
            'status.required' => 'Please determine category status',
            'status.in' => 'Status must be true or false',
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $data['status'] = $data['status'] == 'true';

        if ($this->hasFile('image')) {
            Storage::disk('public')->delete("$this->image");
            $imageName = time() . "" . '.' . $this->file('image')->getClientOriginalExtension();
            $this->file('image')->storePubliclyAs('Category', $imageName, ['disk' => 'public']);
            $data['image'] = 'Category/' . $imageName;
        }
        return $data;
    }
}
