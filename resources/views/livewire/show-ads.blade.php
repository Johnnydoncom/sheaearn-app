
<div class="max-w-6xl mx-auto mt-4">
    <div x-data="showads()">
        <img class="w-full" src="{{ $ads->getFirstMediaUrl('featured_image', 'standard') }}" alt="{{$ads->title}}"/>
        <h1 class="font-bold text-4xl sm:text-5xl py-10 text-center dark:text-gray-200">{{ $ads->title }}</h1>

        <div class="flex items-center justify-center gap-4 mb-10 flex-wrap sm:flex-grow">
            <div class="flex justify-center items-center gap-1 w-full sm:w-auto">
                <img
                    src="{{ $ads->author->avatar_url }}"
                    class="rounded-full w-14 h-14"
                    alt="Avatar"
                />
                <h5 class="text-md font-medium leading-tight dark:text-gray-200">{{ $ads->author->name }}</h5>
            </div>
            <span class="hidden sm:block dark:text-gray-200"><x-cui-cil-circle class="w-2 h-2" /></span>

            <div class="date dark:text-gray-200">{{$ads->created_at->format('F j, Y')}}</div>
            <span class="dark:text-gray-200"><x-cui-cil-circle class="w-2 h-2" /></span>
            <div class="flex items-center gap-2 dark:text-gray-200">
                <svg class="w-4 h-4 dark:text-gray-200" fill="currentColor" viewBox="0 0 576 512"><path d="M540.9 56.77c-45.95-16.66-90.23-24.09-129.1-24.75-60.7.94-102.7 17.45-123.8 27.72-21.1-10.27-64.1-26.8-123.2-27.74-40-.05-84.4 8.35-129.7 24.77C14.18 64.33 0 84.41 0 106.7v302.9c0 14.66 6.875 28.06 18.89 36.8 11.81 8.531 26.64 10.98 40.73 6.781 118.9-36.34 209.3 19.05 214.3 22.19C277.8 477.6 281.2 480 287.1 480c6.52 0 10.12-2.373 14.07-4.578 10.78-6.688 98.3-57.66 214.3-22.27 14.11 4.25 28.86 1.75 40.75-6.812C569.1 437.6 576 424.2 576 409.6V106.7c0-22.28-14.2-42.35-35.1-49.93zM272 438.1c-24.95-12.03-71.01-29.37-130.5-29.37-27.83 0-58.5 3.812-91.19 13.77-4.406 1.344-9 .594-12.69-2.047C34.02 417.8 32 413.1 32 409.6V106.7c0-8.859 5.562-16.83 13.86-19.83C87.66 71.7 127.9 63.95 164.5 64c51.8.81 89.7 15.26 107.5 23.66V438.1zm272-28.5c0 4.375-2.016 8.234-5.594 10.84-3.766 2.703-8.297 3.422-12.69 2.125C424.1 391.6 341.3 420.4 304 438.3V87.66c17.8-8.4 55.7-22.85 107.4-23.66 35.31-.063 76.34 7.484 118.8 22.88 8.2 3 13.8 10.96 13.8 19.82v302.9z"></path></svg>

                <span class="dark:text-gray-200">{{ \Str::readDuration($ads->title, $ads->description). ' min read' }}</span>
            </div>

        </div>

        <div class="entry-content max-w-4xl mx-auto relative px-4 mb-10">
        <div class="flex flex-col justify-center items-center">
            <div class="w-full sm:w-10/12 leading-loose text-md dark:text-gray-200">
                {!! $ads->description !!}

                <div class="flex items-center flex-row sm:flex-col dark:text-gray-200">
                    <button @auth @click.prevent="fbShare" wire:target="shared('{{ config("appstore.social_shares.facebook_id")}}')" wire:loading.class="loading" @else @click.prevent="showLoginModal=true" @endauth class="flex gap-2 items-center justify-center dark:bg-transparent dark:hover:bg-gray-600/20 rounded-full hover:bg-gray-200 px-4 py-2 text-lg text-center">
                        <x-cui-cib-facebook class="w-6 h-6 text-[#4267B2] flex-nonee"/> Share on facebook
                    </button>
                </div>
            </div>

        </div>
    </div>
    </div>

    <script>
        function showads() {
            return {
                user: '{{Auth::user()}}',
                get fbShare(){
                       return FB.ui({
                                method: 'share',
                                name: '{{$ads->title}}',
                                href: '{{url()->current()}}',
                                picture: "{{ $ads->getFirstMediaUrl('featured_image', 'standard') }}",
{{--                                caption: '{{ $ads->excerpt }}',--}}
{{--                                description: "{!! $ads->excerpt !!}"--}}
                            },
                            function(response) {
                                if (response && !response.error_code) {
                                    if (typeof response != 'undefined'){
                                        //shered
                                    @this.shared('{{ config("appstore.social_shares.facebook_id")}}')
                                    }
                                }else if (response && response.post_id) {
                                @this.shared('{{ config("appstore.social_shares.facebook_id")}}')
                                } else {
                                }
                            });

                }
            }
        }
    </script>
</div>
