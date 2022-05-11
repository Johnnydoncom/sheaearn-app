<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}
    <x-slot name="title">Blog</x-slot>
    <div class="py-12">
        <div class="container">
            <div class="grid sm:grid-cols-3 gap-4 grid-cols-1">
                @foreach($sticky_entries as $sticky)
                    @if($loop->first)
                    <div class="col-span-2">
                        @include('partials.post.post-style-big', ['post'=>$sticky, 'sticky'=>true])
                    </div>
                    @endif
                @endforeach

                    <div class="grid grid-cols-1 gap-4">
                @foreach($sticky_entries as $sticky)
                    @if(!$loop->first)
                        <div class="">
                            @include('partials.post.post-style1', ['post'=>$sticky, 'sticky'=>true])
                        </div>
                    @endif
                @endforeach
                    </div>


            </div>
        </div>
    </div>
</x-app-layout>
