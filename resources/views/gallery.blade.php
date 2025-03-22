@extends('layouts.main')

@section('head')
@endsection

@section('content')
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-5 mx-auto">

            {{-- search form --}}
            <div>
                <form class="max-w-md mx-auto" action="{{ route('search') }}" method="GET">
                    @csrf
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <input type="search" id="default-search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="ابحث عن كتاب" name="term" required />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">بحث</button>
                    </div>
                </form>
            </div>
            {{-- end search form --}}
            <hr class="my-4">
            <h3 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4">{{ $title }}</h3>
            @if ($books->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    @foreach ($books as $book)
                        @if ($book->number_of_copies > 0)
                            {{-- Book Card --}}
                            <div
                                class="w-full max-w-sm h-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col">
                                <a href="{{ route('book.details', $book) }}">
                                    <img class="p-8 rounded-t-lg w-full object-cover"
                                        src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" />
                                </a>
                                <div class="px-5 pb-5 flex flex-col justify-between flex-grow">
                                    <div>
                                        <div class="mb-3">
                                            <a href="{{ route('gallery.categories.show', $book->category) }}"
                                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm dark:bg-blue-200 dark:text-blue-800">
                                                {{ $book->category->name }}
                                            </a>
                                        </div>
                                        <a href="{{ route('book.details', $book) }}">
                                            <h5
                                                class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white truncate">
                                                {{ $book->title }}
                                            </h5>
                                        </a>
                                    </div>

                                    <div class="mt-auto">
                                        <div class="flex items-center mt-2.5 mb-5">
                                            <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 22 20">
                                                    <path
                                                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                </svg>
                                            </div>
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm dark:bg-blue-200 dark:text-blue-800 ms-3">{{ 5 }}</span>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-2xl font-bold text-gray-900 dark:text-white">${{ $book->price }}</span>
                                            <a href="#"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                الإضافة للسلة
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="my-10 flex justify-center">
                    <h4 class="text-center text-2xl">لا يوجد كتب</h4>
                </div>
            @endif
            @if ($books->hasPages())
                <div class="mt-10">{{ $books->links() }}</div>
            @endif
        </div>
    </section>
@endsection
