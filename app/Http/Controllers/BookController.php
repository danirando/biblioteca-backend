<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        return response()->json(
            $this->bookService->getAllBooks($request->query('search'))
        );
    }

    public function store(StoreBookRequest $request) // <-- Usa la Form Request
    {
        // Se arrivi qui, i dati sono già stati validati
        $book = $this->bookService->createBook($request->validated());

        return response()->json(['message' => 'Creato!', 'data' => $book], 201);
    }

    public function show($id)
    {
        $book = $this->bookService->findBookById($id);

        return $book
            ? response()->json($book)
            : response()->json(['message' => 'Non trovato'], 404);
    }

    public function update(UpdateBookRequest $request, $id) // <-- Usa la Form Request
    {
        $book = $this->bookService->findBookById($id);
        if (!$book) {
            return response()->json(['message' => 'Non trovato'], 404);
        }

        $updatedBook = $this->bookService->updateBook($book, $request->validated());

        return response()->json(['message' => 'Aggiornato!', 'data' => $updatedBook]);
    }

    public function destroy($id)
    {
        $book = $this->bookService->findBookById($id);
        if (!$book) {
            return response()->json(['message' => 'Non trovato'], 404);
        }

        $this->bookService->deleteBook($book);

        return response()->json(['message' => 'Eliminato']);
    }
}
