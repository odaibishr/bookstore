<!DOCTYPE html>

<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>مكتبة برجنيف</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">

    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f0f0f0;
        }
    </style>
    @yield('head')
</head>

<body dir="rtl" style="text-align: right">

    {{-- Start Header --}}



    <div>
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class=" coantainer max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-black text-2xl font-semibold whitespace-nowrap dark:text-white">مكتبة
                        برجنيف</span>
                </a>
                <div class="flex gap-3 items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    @guest

                        <a href="{{ route('login') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800text-sm dark:text-gray-500">
                            {{ __('تسجيل الدخول') }}
                        </a>
                        <a href="{{ route('register') }}"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2  dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            {{ __('إنشاء حساب') }} </a>
                    @else
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                            data-dropdown-placement="bottom">


                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="user photo">
                        </button>
                    @endguest

                    <!-- Dropdown menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                        id="user-dropdown">

                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
                            <li>
                                <a href="{{ route('profile.show') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    {{ __('Profile') }}
                                </a>
                            </li>

                            <!-- Authentication -->
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </li>
                    </div>
                    <button data-collapse-toggle="navbar-user" type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="navbar-user" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                    <ul
                        class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        @auth
                            <li>

                                <a href="{{ route('cart.show') }}"
                                    class="flex relative gap-1 items-center py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                                    aria-current="page">

                                    <span
                                        class="inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-500 text-white">{{ auth()->user()->booksInCart()->count() ?? 0 }}</span>


                                    <span class="z-10">العربه</span>

                                    <i class="bx z-10 bx-cart text-xl text-gray-500"></i>
                                </a>
                            </li>
                        @endauth
                        <li>
                            <a href="{{ route('gallery.categories.index') }}"
                                class="flex gap-1 items-center py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                                aria-current="page">
                                التصنيفات
                                <i class="bx bx-category text-xl text-gray-500"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gallery.publishers.index') }}"
                                class="flex gap-1 items-center py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                                aria-current="page">
                                الناشرون
                                <i class='bx bx-table text-xl text-gray-500'></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gallery.authors.index') }}"
                                class="flex gap-1 items-center py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                                aria-current="page">
                                المؤلفون
                                <i class="bx bx-pencil text-xl text-gray-500"></i>
                            </a>
                        </li>

                        @auth
                            <li>
                                <a href="#"
                                    class="flex gap-1 items-center py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                                    aria-current="page">
                                    مشترياتي
                                    <i class="bx bx-shopping-bag text-xl text-gray-500"></i>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

    </div>


    {{-- End Header --}}

    {{-- Start Body --}}

    <main class="py-4">
        @yield('content')
    </main>

    {{-- End Body --}}
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @yield('script')
</body>

</html>
