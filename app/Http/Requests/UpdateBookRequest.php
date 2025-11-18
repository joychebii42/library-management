<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $book = $this->route('book');
        $bookId = $book ? (is_object($book) ? $book->id : $book) : null;

        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year_published' => 'required|integer|min:1000|max:'.date('Y'),
            'isbn' => ['required', 'string', 'max:50', Rule::unique('books')->ignore($bookId)],
            'genre' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    
}