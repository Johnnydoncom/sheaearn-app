@props(['review'])

<div class="mt-3 pb-3 border-b text-blue-600">
    <div class="flex justify-between">
        <div class="rating rating-xs lg:rating-md">
            @for ($i = 0; $i < $review->rating; $i++)
            <span type="radio" name="rating-6" class="mask mask-star-2 bg-warning"></span>
            @endfor
            @if($review->rating < 5)
                    @for ($i = 0; $i < (5-$review->rating); $i++)
            <span type="radio" name="rating-6" class="mask mask-star-2 bg-gray-200"></span>
                    @endfor
            @endif
        </div>

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
