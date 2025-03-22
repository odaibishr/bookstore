<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
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
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }

    public function result(Author $author)
    {
        $books = $author->books()->paginate(5);
        $title = 'الكتب التابعة للمؤلف ' . $author->name;

        return view('gallery', compact(['books', 'title']));
    }

    public function list()
    {
        $authors = Author::all()->sortBy('name');
        $title = 'المؤلفون';

        return view('authors.index', compact(['authors', 'title']));
    }

    public function search(Request $request)
    {
        $authors = Author::where('name', 'LIKE', "%{$request->term}%")->get()->sortBy('name');
        $title = 'نتائج البحث عن ' . $request->term;

        return view('authors.index', compact(['authors', 'title']));
    }
}
