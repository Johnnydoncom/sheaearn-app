<x-app-layout>

    <x-slot name="title">@if(request()->s) Search for '{{ request()->s }}' @else Blog @endif</x-slot>
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

                @foreach($entries as $entry)
                    <div class="">
                        @include('partials.post.post-style1', ['post'=>$entry])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
