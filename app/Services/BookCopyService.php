<?php

namespace App\Services;

use App\Models\BookCopy;

class BookCopyService
{
    public function getList($search = null, $perPage = 10)
    {
        $query = BookCopy::query()->with('book');

        if ($search) {
            $query->where('code', 'like', '%' . $search . '%')
                  ->orWhereHas('book', function ($q) use ($search) {
                      $q->where('title', 'like', '%' . $search . '%');
                  });
        }

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return BookCopy::create([
            'book_id' => $data['book_id'],
            'code' => $data['code'],
            'status' => $data['status'],
        ]);
    }
    

    public function update(BookCopy $bookCopy, array $data)
    {
        $bookCopy->update($data);
        return $bookCopy;
    }

    public function delete(BookCopy $bookCopy)
    {
        return $bookCopy->delete();
    }
}
