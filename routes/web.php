<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PublishersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.main');
// });
Route::get('/theme', function () {
    return view('theme.default');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/search', [GalleryController::class, 'search'])->name('search');
Route::get('/book/{book}', [BooksController::class, 'details'])->name('book.details');
Route::get('/categories', [CategoriesController::class, 'list'])->name('gallery.categories.index') ;
Route::get('/categories/search', [CategoriesController::class, 'search'])->name('gallery.categories.search') ;
Route::get('/categories/{category}', [CategoriesController::class, 'result'])->name('gallery.categories.show') ;

Route::get('/publishers', [PublishersController::class, 'list'])->name('gallery.publishers.index') ;
Route::get('/publishers/search', [PublishersController::class, 'search'])->name('gallery.publishers.search') ;
Route::get('/publishers/{publisher}', [PublishersController::class, 'result'])->name('gallery.publishers.show') ;

Route::get('/authors', [AuthorsController::class, 'list'])->name('gallery.authors.index') ;
Route::get('/authors/search', [AuthorsController::class, 'search'])->name('gallery.authors.search') ;
Route::get('/authors/{author}', [AuthorsController::class, 'result'])->name('gallery.authors.show') ;