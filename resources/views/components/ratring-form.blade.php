@props(['book', 'userRating'])

<!-- Rating -->
<div class="flex flex-row-reverse justify-end items-center">
    @for ($i = 5; $i >= 1; $i--)
        <input id="hs-ratings-readonly-{{ $i }}" type="radio"
            class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
            name="hs-ratings-readonly" value="{{ $i }}"
            @if (isset($userRating) && $userRating->value == $i) checked @else unchecked @endif onclick="rateBook({{ $i }})">
        <label for="hs-ratings-readonly-{{ $i }}"
            class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                </path>
            </svg>
        </label>
    @endfor
</div>
<!-- End Rating -->

<script>
    function rateBook(ratingValue) {



        const bookId = {{ $book->id }}; // تأكد من تمرير معرف الكتاب إلى الصفحة

        fetch({{ $book->id }} + '/rate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    // book_id: bookId,
                    value: ratingValue
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                    toastr.success('Have fun storming the castle!', 'Miracle Max Says')
                    
                } else {
                    toastr.success('Have fun storming the castle!', 'Miracle Max Says')
                    window.location.reload();
                    console.error('حدث خطأ أثناء التقييم');
                }
            })
            .catch(error => {
                window.location.reload();
                console.error('Error:', error);
            });

    }
</script>
