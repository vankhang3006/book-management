<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookService
{
    public function getList(string $search = null, $perPage = 5)
    {
        $query = Book::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('books', 'public');
        }

        return Book::create($data);
    }

    public function update(Book $book, array $data)
    {
        if (isset($data['image'])) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }

            $data['image'] = $data['image']->store('books', 'public');
        }

        return $book->update($data);
    }

    public function delete(Book $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        return $book->delete();
    }
}
