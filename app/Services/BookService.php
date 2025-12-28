<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getAllBooks(?string $search)
    {
        return Book::when($search, function ($query, $search) {
            return $query->where('titolo', 'like', "%{$search}%")
                         ->orWhere('autore', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10);
    }

    public function createBook(array $data): Book
    {
        return Book::create($data);
    }

    public function findBookById(int $id): ?Book
    {
        return Book::find($id);
    }

    public function updateBook(Book $book, array $data): Book
    {
        $book->update($data);
        return $book;
    }

    public function deleteBook(Book $book): bool
    {
        return $book->delete();
    }
}
