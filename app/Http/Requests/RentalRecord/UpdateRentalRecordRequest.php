<?php

namespace App\Http\Requests\RentalRecord;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRentalRecordRequest extends FormRequest
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
            'book_copy_id' => 'required|exists:book_copies,id',
            'user_id' => 'required|exists:users,id',
            'rented_at' => 'required|date',
            'due_date' => 'required|date|after:rented_at',
            'returned_at' => 'nullable|date|after_or_equal:rented_at', // Nếu có, ngày trả phải sau hoặc cùng ngày với ngày thuê
        ];
    }
}
