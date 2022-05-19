
    <div x-data="{showComment:false,showMoreActions: false}"
    class="max-w-6xl mx-auto mt-4">
        <img class="w-full" src="{{ $entry->getFirstMediaUrl('featured_image', 'standard') }}" alt="{{$entry->title}}"/>
        <h1 class="font-bold text-4xl sm:text-5xl py-10 text-center dark:text-gray-200">{{ $entry->title }}</h1>

        <div class="flex items-center justify-center gap-4 mb-10 flex-wrap sm:flex-grow">
            <div class="flex justify-center items-center gap-1 w-full sm:w-auto">
                <img
                    src="{{ $entry->author->avatar_url }}"
                    class="rounded-full w-14 h-14"
                    alt="Avatar"
                />
                <h5 class="text-md font-medium leading-tight dark:text-gray-200">{{ $entry->author->name }}</h5>
            </div>
            <span class="hidden sm:block dark:text-gray-200"><x-cui-cil-circle class="w-2 h-2" /></span>

            <div class="date dark:text-gray-200">{{$entry->created_at->format('F j, Y')}}</div>
            <span class="dark:text-gray-200"><x-cui-cil-circle class="w-2 h-2" /></span>
            <div class="flex items-center gap-2 dark:text-gray-200">
                <svg class="w-4 h-4 dark:text-gray-200" fill="currentColor" viewBox="0 0 576 512"><path d="M540.9 56.77c-45.95-16.66-90.23-24.09-129.1-24.75-60.7.94-102.7 17.45-123.8 27.72-21.1-10.27-64.1-26.8-123.2-27.74-40-.05-84.4 8.35-129.7 24.77C14.18 64.33 0 84.41 0 106.7v302.9c0 14.66 6.875 28.06 18.89 36.8 11.81 8.531 26.64 10.98 40.73 6.781 118.9-36.34 209.3 19.05 214.3 22.19C277.8 477.6 281.2 480 287.1 480c6.52 0 10.12-2.373 14.07-4.578 10.78-6.688 98.3-57.66 214.3-22.27 14.11 4.25 28.86 1.75 40.75-6.812C569.1 437.6 576 424.2 576 409.6V106.7c0-22.28-14.2-42.35-35.1-49.93zM272 438.1c-24.95-12.03-71.01-29.37-130.5-29.37-27.83 0-58.5 3.812-91.19 13.77-4.406 1.344-9 .594-12.69-2.047C34.02 417.8 32 413.1 32 409.6V106.7c0-8.859 5.562-16.83 13.86-19.83C87.66 71.7 127.9 63.95 164.5 64c51.8.81 89.7 15.26 107.5 23.66V438.1zm272-28.5c0 4.375-2.016 8.234-5.594 10.84-3.766 2.703-8.297 3.422-12.69 2.125C424.1 391.6 341.3 420.4 304 438.3V87.66c17.8-8.4 55.7-22.85 107.4-23.66 35.31-.063 76.34 7.484 118.8 22.88 8.2 3 13.8 10.96 13.8 19.82v302.9z"></path></svg>

                <span class="dark:text-gray-200">{{ \Str::readDuration($entry->title, $entry->description). ' min read' }}</span>
            </div>

        </div>

        <div class="entry-content max-w-4xl mx-auto relative px-4">
            <div class="grid grid-cols-5 gap-4">
                <div class="col-span-5 sm:col-span-4 leading-loose text-md dark:text-gray-200">
                    {!! $entry->description !!}
                </div>
                <div class="flex items-center flex-row sm:flex-col dark:text-gray-200">

                    <div class="sticky top-0 p-5 text-gray-600">
                        <div class="floating-icons flex flex-row sm:flex-col justify-center sm:space-y-8">
                            @auth
                            <button wire:click="like" wire:loading.class="loading" wire:target="like" class="btn btn-ghost flex gap-2 items-center bg-transparent dark:bg-transparent dark:hover:bg-gray-600/20 rounded-full hover:bg-gray-200 px-4 py-2 text-lg text-center">
                                <x-cui-cil-happy class="w-6 h-6 flex-none"/>
                                @if($isLiked)
                                    1
                                @else
                                Like
                                @endif
                            </button>
                            @else
                            <a href="{{ route('login') }}" class="flex gap-2 items-center dark:bg-transparent dark:hover:bg-gray-600/20 rounded-full hover:bg-gray-200 px-4 py-2 text-lg text-center">
                                <x-cui-cil-happy class="w-6 h-6 flex-none"/>
                                Like
                            </a>
                            @endauth


                            <a href="#comment" class="flex gap-2 items-center justify-center dark:bg-transparent dark:hover:bg-gray-600/20 rounded-full hover:bg-gray-200 px-4 py-2 text-lg text-center" @click="showComment=true">
                                <x-far-comment-dots class="w-6 h-6"/>
                            </a>
                            <button @auth wire:click="addBookmark" wire:target="addBookmark" wire:loading.class="loading" @else @click="showLoginModal=true" @endauth class="btn btn-ghost flex gap-2 items-center justify-center dark:bg-transparent dark:hover:bg-gray-600/20 rounded-full hover:bg-gray-200 px-4 py-2 text-lg text-center">
                                @if($isBookmarked)
                                <x-fas-bookmark class="w-6 h-6 text-primary"/>
                                @else
                                <x-cui-cil-bookmark class="w-6 h-6"/>
                                @endif

                            </button>
                            <a href="{{ $shareUrls['twitter'] }}" target="_blank" class="social-button flex gap-2 items-center justify-center bg-white dark:bg-transparent dark:hover:bg-gray-600/20 rounded-full hover:bg-gray-200 px-4 py-2 text-lg text-center">
                                <x-cui-cib-twitter class="w-6 h-6"/>
                            </a>

                            @if(1>0)
                            <div class="dropdown dropdown-left dropdown-end ">
                                <label tabindex="0" class="btn border-none flex gap-2 items-center justify-center bg-white rounded-full hover:bg-gray-200 px-4 py-2 text-lg text-center text-gray-600 xl:min-h-0 m-1">
                                    <x-cui-cil-account-logout class="w-6 h-6 rotate-90"/>
                                </label>
                                <div tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-96">
                                    <ul class="menu grid grid-cols-2 gap-4">
                                        <li>
                                            <a class="nav-item social-button" href="{{ $shareUrls['twitter'] }}" >
                                                <x-cui-cib-twitter class="w-6 h-6 text-[#1DA1F2]"/> Tweet this
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:fbShare()" class="ssocial-button">
                                                <x-cui-cib-facebook class="w-6 h-6 text-[#4267B2]"/> Facebook
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $shareUrls['linkedin'] }}" class="social-button">
                                                <x-cui-cib-linkedin class="w-6 h-6 text-[#4267B2]"/> LinkedIn
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $shareUrls['reddit'] }}" class="social-button">
                                                <x-cui-cib-reddit class="w-6 h-6 text-[#FF4500]"/>
                                                Reddit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $shareUrls['telegram'] }}" class="social-button">
                                                <x-cui-cib-telegram class="w-6 h-6 text-[#FF4500]"/>Telegram
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $shareUrls['whatsapp'] }}" class="social-button">
                                                <x-cui-cib-whatsapp class="w-6 h-6 text-[#25D366]"/>WhatsApp
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="divider my-2"></div>
                                    <div class="form-control">
                                        <x-label value="Permalink" class="mb-2"/>
                                        <x-input type="text" class="input w-full bg-slate-100 rounded-xl" value="{{\Illuminate\Support\Facades\URL::current()}}" readonly />
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>


                    </div>
                </div>
            </div>

            @auth
            {{-- <template x-show="showComment"> --}}
                <div id="comment" class="" x-show="showComment">
                    <form method="post" wire:submit.prevent="comment">
                        @csrf
                        <div class="flex justify-center card border ">
                            <div class="block rounded-lg shadow-lg bg-white text-center">
                                <div class="py-3 px-6 border-b border-gray-300 text-left">
                                   <div class="flex items-center gap-2">
                                       <img src="{{Auth::user()->avatar_url}}" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full">
                                    {{ Auth::user()->name }}
                                   </div>
                                </div>
                                <div class="p-2">
                                    {{--                            <h5 class="text-gray-900 text-xl font-medium mb-2">Special title treatment</h5>--}}
                                    <textarea class="textarea textarea-ghost rounded-none ring-0 w-full border-none focus:border-none focus:ring-0 focus:outline-none" placeholder="Start typing" rows="5" wire:model="body" required></textarea>
                                </div>
                                <div class="py-3 px-6 border-t border-gray-300 text-gray-600 flex justify-between items-center">
                                    <span>Read the code of conduct before adding a comment.</span>
                                    <x-button class="btn btn-secondary btn-outline gap-2 rounded-full"><x-far-paper-plane class="w-5 h-5 flex-none" />Post</x-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            {{-- </template> --}}
            @endauth
        </div>

    </div>



@push('scripts')

<script>
    // function fbShare(url, title, descr, image, winWidth=780, winHeight=550) {
    //     var winTop = (screen.height / 2) - (winHeight / 2);
    //     var winLeft = (screen.width / 2) - (winWidth / 2);
    //     window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight).then(resp=>{
    //         console.log('resp: ',resp)
    //     });

    // }

    var popupSize = {
        width: 780,
        height: 550
    };
    const socialBtns = document.querySelectorAll('.social-button');

    socialBtns.forEach(sbtn => {
        sbtn.addEventListener('click', function handleClick(event) {
            // console.log('btn clicked', event.target.getAttribute('href'));

            var verticalPos = Math.floor((screen.width - popupSize.width) / 2),
                horisontalPos = Math.floor((screen.heigh - popupSize.height) / 2);

            var popup = window.open(event.target.getAttribute('href'), 'social',
                'width=' + popupSize.width + ',height=' + popupSize.height +
                ',left=' + verticalPos + ',top=' + horisontalPos +
                ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

            if (popup) {
                popup.focus();
                event.preventDefault();
                console.log(1)
            }else{
                console.log(0)
            }
        });
    });
</script>
<script>
   function fbShare(){
    FB.ui({
        method: 'share',
        name: '{{$entry->title}}',
        href: '{{url()->current()}}',
        picture: '{{ $entry->getFirstMediaUrl('featured_image', 'standard') }}',
        caption: 'Reference Documentation',
        description: '{{ $entry->excerpt }}'
    },
    function(response) {
        if (response && response.post_id) {
        alert('Post was published.');
        } else {
        alert('Post was not published.');
        }
    });
   }
</script>
@endpush
