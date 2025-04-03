@include('layouts.main')

<section class="relative">
    @if ($items->count())
        <div class="w-full max-w-7xl px-4 py-4 md:px-5 lg-6 mx-auto">

            <h2 class="title font-manrope font-bold text-4xl leading-10 mb-8 text-center text-black">
                سلة المشتريات
            </h2>
            <div class="hidden lg:grid grid-cols-2 py-6">
                <div class="font-normal text-xl leading-8 text-gray-500">
                    الكتاب</div>
                <p class="font-normal text-xl leading-8 text-gray-500 flex items-center justify-between">
                    <span class="w-full max-w-[200px] text-center">السعر
                    </span>
                    <span class="w-full max-w-[260px] text-center">الكمية</span>
                    <span class="w-full max-w-[200px] text-center">المجموع</span>
                    <span class="w-full max-w-[200px] text-center">خيارات</span>
                </p>
            </div>
            @php($totalPrcie = 0)
            @foreach ($items as $item)
                @php($totalPrcie += $item->price * $item->pivot->number_of_copies)

                <div class="grid grid-cols-1 lg:grid-cols-2 min-[550px]:gap-6 border-t border-gray-200 py-6">
                    <div
                        class="flex items-center flex-col min-[550px]:flex-row gap-3 min-[550px]:gap-6 w-full max-xl:justify-center max-xl:max-w-xl max-xl:mx-auto">
                        <div class="img-box"><img src="{{ asset('storage/' . $item->cover_image) }}"
                                alt="perfume bottle image" class="xl:w-[140px] rounded-xl object-cover">
                        </div>
                        <div class="pro-data w-full max-w-sm ">
                            <h5 class="font-semibold text-xl leading-8 text-black max-[550px]:text-center">
                                {{ $item->title }}
                            </h5>
                            <p
                                class="font-normal text-lg leading-8 text-gray-500 my-2 min-[550px]:my-3 max-[550px]:text-center">
                                {{ $item->category->name }}
                            </p>

                        </div>
                    </div>
                    <div
                        class="flex items-center flex-col min-[550px]:flex-row w-full max-xl:max-w-xl max-xl:mx-auto gap-2">
                        <h6
                            class="font-manrope font-bold text-2xl leading-9 text-black w-full max-w-[176px] text-center">
                            {{ $item->price }}
                        </h6>
                        <div class="flex items-center font-manrope font-bold text-2xl w-full mx-auto justify-center">
                            {{ $item->pivot->number_of_copies }}
                        </div>
                        <h6
                            class="text-indigo-600 font-manrope font-bold text-2xl leading-9 w-full max-w-[176px] text-center">
                            {{ $item->price * $item->pivot->number_of_copies }}
                        </h6>
                        <h6
                            class="text-indigo-600 font-manrope font-bold text-2xl leading-9 w-full max-w-[176px] text-center">

                            <form action="{{ route('cart.remove_one', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                    حذف عنصر
                                </button>
                            </form>
                            <form action="{{ route('cart.remove_all', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                    حذف الكل
                                </button>
                            </form>
                        </h6>
                    </div>
                </div>
                <hr class="w-48 h-1 mx-auto my-4 bg-gray-300 border-0 rounded-sm md:my-10 dark:bg-gray-700">
            @endforeach


            <div class="bg-gray-50 rounded-xl p-6 w-full mb-8 max-lg:max-w-xl max-lg:mx-auto">
                <div class="flex items-center justify-between w-full mb-6">
                    <p class="font-normal text-xl leading-8 text-gray-400">
                        المجموع</p>
                    <h6 class="font-semibold text-xl leading-8 text-gray-900">
                        ${{ $totalPrcie }}</h6>
                </div>
                <div class="flex items-center justify-between w-full pb-6 border-b border-gray-200">
                    <p class="font-normal text-xl leading-8 text-gray-400">
                        الضرائب</p>
                    <h6 class="font-semibold text-xl leading-8 text-gray-900">
                        $0</h6>
                </div>
                <div class="flex items-center justify-between w-full py-6">
                    <p class="font-manrope font-medium text-2xl leading-9 text-gray-900">
                    <h6 class="font-manrope font-medium text-2xl leading-9 text-indigo-500">
                        ${{ $totalPrcie }}</h6>
                </div>
            </div>
            <div class="flex items-center flex-col sm:flex-row justify-center gap-3 mt-8">
                <a href="#"
                    class="flex gap-2 text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                    <span>بطاقة ائتمانية</span>
                    <i class='bx bx-credit-card-alt'></i>
                </a>
            </div>
        </div>
    @else
        <div class="my-10 flex justify-center">
            <h4 class="text-center text-2xl">لا يوجد كتب</h4>
        </div>
    @endif
</section>

