@props(['review'])

<div class="mt-3 pb-3 border-b text-blue-600">
    <div class="flex justify-between">
        <ul class="flex justify-center">
            @for ($i = 0; $i < $review->rating; $i++)
            <li>
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="w-4 text-yellow-500 mr-1" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
                </svg>
            </li>
            @endfor
                @if($review->rating < 5)
                    @for ($i = 0; $i < (5-$review->rating); $i++)
            <li>
                <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="w-4 text-yellow-500 mr-1" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"></path>
                </svg>
            </li>
                    @endfor
                @endif
        </ul>



        <div class="review-date font-light text-sm lg:text-base">
            {{ $review->created_at->format('j F, Y') }}
        </div>
    </div>

    <div class="text-xs lg:text-base">
        {{ $review->review }}
    </div>
    <div class="flex justify-between items-center mt-1">
        <span class="text-xs lg:text-base">{{ $review->user->name}}</span>
        <span class="text-xs lg:text-base text-success">
                Verified Purchase
            </span>
    </div>
</div>
