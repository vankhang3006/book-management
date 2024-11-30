<?php

namespace App\Http\Requests\BookCopy;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookCopyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'book_id' => 'required|exists:books,id',
            'code' => 'required|unique:book_copies,code|max:255',
            'status' => 'required|in:available,borrowed',
        ];
    }
}
