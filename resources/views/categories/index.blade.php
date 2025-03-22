@extends('layouts.main')

@section('content')
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            {{-- search form --}}
            <div>
                <form class="max-w-md mx-auto" action="{{ route(name: 'gallery.categories.search') }}" method="GET">
                    @csrf
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <input type="search" id="default-search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="ابحث عن تصنيف" name="term" required />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">بحث</button>
                    </div>
                </form>
            </div>
            {{-- end search form --}}

            <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">{{ $title }}</h2>
            </div>

            @if ($categories->count())
                <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach($categories as $category)
                    <a href="{{ route('gallery.categories.show', $category) }}"
                        class="flex justify-between items-center rounded-lg border border-gray-200 bg-white px-4 py-2 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</span>
                        <span> {{ $category->books->count() }}</span>

                    </a>
                    @endforeach

                </div>
            @else
                <div class="my-10 flex justify-center">
                    <h4 class="text-center text-2xl">لا يوجد تصنيفات</h4>
                </div>
            @endif


        </div>
    </section>
@endsection
