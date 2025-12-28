<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        $books = $this->bookService->getAllBooks($request->query('search'));

        // collection() si usa per liste di dati impaginati
        return BookResource::collection($books);
    }

    public function store(StoreBookRequest $request)
    {
        $book = $this->bookService->createBook($request->validated());

        return (new BookResource($book))
            ->additional(['message' => 'Libro creato con successo!'])
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $book = $this->bookService->findBookById($id);

        if (!$book) {
            return response()->json(['message' => 'Non trovato'], 404);
        }

        // Ritorna il singolo oggetto trasformato
        return new BookResource($book);
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
