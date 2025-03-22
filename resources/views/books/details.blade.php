@extends('layouts.main')

@section('content')
    <section class="container px-4 sm:px-6 mx-auto py-8 bg-white dark:bg-gray-900 transition-colors">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <!-- صورة الغلاف -->
            <div class="flex justify-center">
                <img class="max-w-full h-auto rounded-lg shadow-md" src="{{ asset('storage/' . $book->cover_image) }}"
                    alt="{{ $book->title }}">
            </div>

            <!-- معلومات الكتاب -->
            <div>
                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 tracking-widest">العنوان</h2>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $book->title }}</h1>

                @if ($book->authors->count() > 0)
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mt-4">المؤلفون</h2>
                    <p class="text-lg text-gray-900 dark:text-white">
                        @foreach ($book->authors as $author)
                            {{ $loop->first ? '' : ' و' }}<span class="font-medium">{{ $author->name }}</span>
                        @endforeach
                    </p>
                @endif

                <div class="flex flex-wrap gap-4 mt-4">
                    @if ($book->category)
                        <div>
                            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400">التصنيف</h2>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $book->category->name }}</p>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400">السعر</h2>
                        <p class="text-lg font-medium text-green-600 dark:text-green-400">{{ $book->price }}$</p>
                    </div>
                </div>

                @if ($book->description)
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mt-5">الوصف</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $book->description }}</p>
                @endif

                <div class="flex flex-wrap gap-6 mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div>
                        <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد الصفحات</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->number_of_pages }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد النسخ</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->number_of_copies }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    {{-- <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $book->price }}$</span> --}}
                    <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-indigo-700 transition">
                        إضافة إلى السلة
                    </button>
                    <button
                        class="w-10 h-10 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-full shadow-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

@endsection
