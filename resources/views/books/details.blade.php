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

                <h2 class="text-sm mt-4 font-semibold text-gray-500 dark:text-gray-400">تقييم المستخدمين</h2>
                <div class="flex flex-wrap gap-4">
                    <div class="mt-auto">
                        <div class="flex items-center mt-2.5 mb-5">
                            <div class="flex items-center space-x-1">
                                <div class="flex items-center">
                                    @php
                                        $averageRating = $book->ratings->avg('value');
                                        $fullStars = floor($averageRating);
                                        $hasHalfStar = $averageRating - $fullStars >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                    @endphp

                                    @for ($i = 1; $i <= $fullStars; $i++)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endfor

                                    @if ($hasHalfStar)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half-star">
                                                    <stop offset="50%" stop-color="currentColor"></stop>
                                                    <stop offset="50%" stop-color="#d1d5db"></stop>
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half-star)"
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endif

                                    @for ($i = 1; $i <= $emptyStars; $i++)
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endfor

                                    <span class="ml-1 text-gray-600 text-sm">({{ number_format($averageRating, 1) }})</span>
                                </div>
                            </div>


                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm dark:bg-blue-200 dark:text-blue-800 ms-3">
                                عدد التقييمات {{ $book->ratings()->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <hr class="w-48 h-1  bg-gray-100 border-0 rounded-sm dark:bg-gray-700">


                <div class="flex flex-wrap gap-4 mt-4">
                    @if ($book->category)
                        <div>
                            <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400">التصنيف</h2>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $book->category->name }}</p>
                        </div>
                    @endif
                </div>


                @if ($book->description)
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mt-5">الوصف</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $book->description }}</p>
                @endif
                <hr class="h-px my-3 bg-gray-200 border-0 dark:bg-gray-700">

                <div class="flex flex-wrap gap-6">
                    <div>
                        <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد الصفحات</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->number_of_pages }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد النسخ</h3>
                        <p class="text-gray-900 dark:text-white">{{ $book->number_of_copies }}</p>
                    </div>
                </div>

                <div class=" mt-4 flex flex-wrap gap-4 items-center">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400">السعر</h2>
                    {{-- <p class="text-lg font-medium text-green-600 dark:text-green-400">{{ $book->price }}$</p> --}}
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $book->price }}$</span>

                </div>

                <hr class="w-48 h-1 my-4 bg-gray-100 border-0 rounded-sm dark:bg-gray-700">

                {{-- <livewire:star-rating-component :userId="auth()->user()->id" :bookId="$book->id" /> --}}
                <x-ratring-form :book="$book" :userRating="$book
                    ->ratings()
                    ->where('user_id', auth()->id())
                    ->first()" />


                @auth
                    <form id="add-to-cart-form" class="flex flex-wrap items-center gap-4 mt-6">
                        @csrf
                        <input type="hidden" id="bookId" value="{{ $book->id }}" name="book_id">
                        <div class="relative flex items-center max-w-[8rem]">
                            <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input"
                                class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M1 1h16" />
                                </svg>
                            </button>
                            <input type="text" id="quantity-input" data-input-counter data-input-counter-min="1"
                                data-input-counter-max="{{ $book->number_of_copies }}" name="quantity"
                                class="text-center w-full h-11" value="1" required />
                            <button type="button" id="increment-button" data-input-counter-increment="quantity-input"
                                class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 1v16M1 9h16" />
                                </svg>
                            </button>

                        </div>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-indigo-700 transition">
                            إضافة إلى السلة
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </section>

    <script>
        document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('cart.add') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value,
                        "Accept": "application/json"
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.warning_message) {
                        document.getElementById('cart-message').textContent = data.warning_message;
                        document.getElementById('cart-message').classList.remove('hidden');
                    } else {
                        alert(data.message); // يمكن استبداله بتحديث عدد المنتجات في السلة
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

@endsection
