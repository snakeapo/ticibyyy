<?php

namespace Modules\Blog\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class BlogCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'blog_title' => ['required'],
            'blog_desc' => ['required'],
            'blog_category' => ['required'],
            'blog_tag' => ['required'],
            'meta_title' => ['required'],
            'meta_keyw' => ['required'],
            'meta_desc' => ['required'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ];
    }
}
