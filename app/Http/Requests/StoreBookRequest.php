<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year_published' => 'required|integer|min:1000|max:' . date('Y'),
            'isbn' => 'required|string|max:50|unique:books,isbn',
            'genre' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ];
    }
}