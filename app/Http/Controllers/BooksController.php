<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }

    public function details(Book $book)
    {
        return view('books.details', compact('book'));
    }

    public function rate(Request $request, Book $book)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'يجب تسجيل الدخول لتقييم الكتاب.'], 401);
        }

        $validatedData = $request->validate([
            'value' => 'required|integer|min:1|max:5'
        ]);


        Rating::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $book->id],
            ['value' => $validatedData['value']]
        );
        return back();
    }
}
