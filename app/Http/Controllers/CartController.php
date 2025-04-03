<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Contracts\Session\Session;


class CartController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function addToCart(Request $request)
    {
        $book = Book::find($request->book_id);

        $user = auth()->user();
        $existingCartItem = $user->booksInCart()->where('books.id', $book->id)->first();

        $newQuantity = $request->quantity + ($existingCartItem ? $existingCartItem->pivot->number_of_copies : 0);

        if ($newQuantity > $book->number_of_copies) {
            return response()->json([
                'success' => false,
                'message' => 'لقد تجاوزت الكمية المتاحة للكتاب. الكمية المتاحة: ' . $book->number_of_copies
            ], 422);
        }

        if ($existingCartItem) {
            $user->booksInCart()->updateExistingPivot($book->id, [
                'number_of_copies' => $newQuantity
            ]);
        } else {
            $user->booksInCart()->attach($book->id, [
                'number_of_copies' => $request->quantity
            ]);
        }


        toastr()->success('تمت إضافة الكتاب إلى السلة بنجاح');
        
        return response()->json([
            'success' => true,
            'cart_count' => $user->booksInCart()->count(),
            'message' => 'تمت إضافة الكتاب إلى السلة بنجاح'
        ]);
    }


    public function showCart()
    {
        $items = auth()->user()->booksInCart;
        return view('cart', compact('items'));
    }

    public function removeOne(Book $book)
    {
        $user = auth()->user();
        $oldQuantity = $user->booksInCart()->where('book_id', $book->id)->first()->pivot->number_of_copies;
        if ($oldQuantity > 1) {
            auth()->user()->booksInCart()->updateExistingPivot($book->id, ['number_of_copies' => --$oldQuantity]);
        } else {
            auth()->user()->booksInCart()->detach($book->id);
        }

        toastr()->success('تمت إزالة نسخة من الكتاب من السلة بنجاح');

        return back();
    }

    public function removeAll(Book $book)
    {
        auth()->user()->booksInCart()->detach($book->id);

        toastr()->success('تمت إزالة كل نسخ من الكتاب من السلة بنجاح');

        return back();
    }
}
