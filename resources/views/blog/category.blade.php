<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}
    <x-slot name="title">{{ $category->name }}</x-slot>
    <div class="py-12">
        <div class="container">
            <h2 class="text-3xl font-semibold">{{ $category->name }}</h2>
            <div class="divider mt-0"></div>
            <div class="grid sm:grid-cols-4 gap-4 grid-cols-1">
                    <div class="col-span-3 grid grid-cols-1 gap-4">
                    @foreach($entries as $entry)
                            @include('partials.post.post-style2', ['post'=>$entry])
                    @endforeach
                    </div>
                <div class="col-span-1">
                    ggg
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
