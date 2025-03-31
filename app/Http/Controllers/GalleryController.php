<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Book;


class GalleryController extends Controller
{
    public function index()
    {
        $books = Book::paginate(8);
        $title = 'معرض الكتب';

        return view('gallery', compact(['books', 'title']));
    }

    public function search(Request $request)
    {
        $books = Book::where('title', 'LIKE', "%{$request->term}%")->paginate(5);
        $title = 'نتائج البحث عن ' . $request->term;

        return view('gallery', compact(['books', 'title']));
    }
}
