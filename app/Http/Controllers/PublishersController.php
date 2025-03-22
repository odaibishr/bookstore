<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublishersController extends Controller
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
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        //
    }

    public function result(Publisher $publisher)
    {
        $books = $publisher->books()->paginate(5);
        $title = 'الكتب التابعة للناشر ' . $publisher->name;

        return view('gallery', compact(['books', 'title']));
    }

    public function list()
    {
        $publishers = Publisher::all()->sortBy('name');
        $title = 'الناشرون';

        return view('publishers.index', compact(['publishers', 'title']));
    }

    public function search(Request $request)
    {
        $publishers = Publisher::where('name', 'LIKE', "%{$request->term}%")->get()->sortBy('name');
        $title = 'نتائج البحث عن ' . $request->term;

        return view('publishers.index', compact(['publishers', 'title']));
    }
}
