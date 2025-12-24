<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // BookController.php
    // BookController.php
    public function index(Request $request)
    {
        $search = $request->query('search');

        $books = Book::when($search, function ($query, $search) {
            return $query->where('titolo', 'like', "%{$search}%")
                         ->orWhere('autore', 'like', "%{$search}%");
        })
        ->latest() // <--- Questo mette i nuovi inserimenti in cima
        ->paginate(10);

        return response()->json($books);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validazione dei dati
        $validated = $request->validate([
            'titolo'      => 'required|string|max:255',
            'autore'      => 'required|string|max:255',
            'anno'        => 'required|integer|min:1000|max:' . date('Y'),
            'genere'      => 'required|string|max:100',
            'descrizione' => 'nullable|string',
        ]);

        // 2. Creazione del libro nel database
        // Il metodo create restituisce l'oggetto appena creato
        $book = Book::create($validated);

        // 3. Risposta in formato JSON
        // Restituiamo il libro creato e lo status code 201 (Created)
        return response()->json([
            'message' => 'Libro creato con successo!',
            'data'    => $book
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // 1. Cerca il libro tramite l'ID
        $book = Book::find($id);

        // 2. Se non esiste, restituisci un errore 404
        if (!$book) {
            return response()->json([
                'message' => 'Libro non trovato'
            ], 404);
        }

        // 3. Se esiste, restituisci il libro in JSON (default status 200)
        return response()->json($book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Trova il libro nel database
        $book = Book::find($id);

        // 2. Se non esiste, restituisci errore 404
        if (!$book) {
            return response()->json(['message' => 'Libro non trovato'], 404);
        }

        // 3. Valida i dati in arrivo
        // Usiamo 'sometimes' così è possibile aggiornare anche solo un campo alla volta
        $validated = $request->validate([
            'titolo'      => 'sometimes|required|string|max:255',
            'autore'      => 'sometimes|required|string|max:255',
            'anno'        => 'sometimes|required|integer|min:1000|max:' . date('Y'),
            'genere'      => 'sometimes|required|string|max:100',
            'descrizione' => 'nullable|string',
        ]);

        // 4. Aggiorna i campi del libro
        $book->update($validated);

        // 5. Restituisci il libro aggiornato con status 200 (OK)
        return response()->json([
            'message' => 'Libro aggiornato con successo!',
            'data'    => $book
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Trova il libro nel database
        $book = Book::find($id);

        // 2. Se non esiste, restituisci errore 404
        if (!$book) {
            return response()->json(['message' => 'Libro non trovato'], 404);
        }

        // 3. Elimina il libro
        $book->delete();

        // 4. Restituisci la risposta
        // Opzione A: Messaggio di conferma (Status 200)
        return response()->json(['message' => 'Libro eliminato correttamente'], 200);

        // Opzione B: Solo status code senza contenuto (Status 204 No Content)
        // return response()->json(null, 204);
    }
}
