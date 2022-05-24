<x-account-layout>
<div>
    <div class="card border-b rounded-none mb-4">
        <div class="card-body px-0 py-2 flex-row items-center gap-4">
            <div class="avatar online">
                <div class="w-14 sm:w-24 rounded-full">
                    <img src="{{ Auth::user()->avatar_url }}" />
                </div>
            </div>
            <div>
                <h2 class="font-semibold text-lg sm:text-2xl">{{Auth::user()->name}}</h2>
                <p class="font-normal text-sm text-gray-400">Account ID: {{Auth::user()->account_id}}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 md:grid-cols-2 xl:grid-cols-3 gap-1 sm:gap-6">
        <div class="px-2 sm:px-6 py-2 sm:py-6 bg-white rounded-lg shadow sm:shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-normal sm:font-bold text-xs sm:text-sm text-primary">All Time Earning</span>
            </div>
            <div class="flex items-center justify-between mt-2 sm:mt-6">
                <div class="hidden sm:block">
                    <svg class="w-4 h-4 sm:w-12 2xl:w-16 sm:h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-primary border border-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-sm sm:text-2xl 2xl:text-3xl font-bold">{{ app_money_format($allTimeEarning) }}</span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-2 sm:px-6 py-2 sm:py-6 bg-white rounded-lg shadow sm:shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-normal sm:font-bold text-xs sm:text-sm text-primary">Sales Earning</span>
            </div>
            <div class="flex items-center justify-between mt-2 sm:mt-6">
                <div class="hidden sm:block">
                    <svg class="w-4 h-4 sm:w-12 2xl:w-16 sm:h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-primary border border-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-sm sm:text-2xl 2xl:text-3xl font-bold">{{ app_money_format($salesEarning) }}</span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-2 sm:px-6 py-2 sm:py-6 bg-white rounded-lg shadow sm:shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-normal sm:font-bold text-xs  sm:text-sm text-primary">Social Earning</span>
            </div>
            <div class="flex items-center justify-between mt-2 sm:mt-6">
                <div class="hidden sm:block">
                    <svg class="w-4 h-4 sm:w-12 2xl:w-16 sm:h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-primary border border-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-sm sm:text-2xl 2xl:text-3xl font-bold">{{ app_money_format($socialEarning) }}</span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @role(\App\Enums\UserRole::AFFILIATE)
    <div class="container flex justify-center items-center my-6">
        <div class="relative w-full">
            <input type="text" class="w-full sm:pl-10 sm:pr-60 pl-10 pr-10 h-16 rounded-full text-xl z-0 focus:shadow focus:outline-none border-primary" value="{{Auth::user()->referral_link}}" readonly>
            <div class="absolute top-0 bottom-2 right-1 msy-2 sdm:mt-auto flex flex-col h-full items-center">
                <button class="w-full h-full sm:w-auto my-1 px-12 py-2 text-white bg-primary text-lg hover:bg-primary rounded-full">Copy</button>
            </div>
        </div>
    </div>

{{--            <div class="input-group relative flex flex-wrap items-stretch w-full mb-4">--}}
{{--                <input type="text" class="form-control w-full relative flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-primary focus:outline-none" value="{{Auth::user()->referral_link}}" aria-describedby="button-addon3">--}}
{{--                <button class="btn inline-block px-6 py-2 border-2 border-primary text-primary font-medium text-xs leading-tight uppercase rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out" type="button" id="button-addon3">Copy</button>--}}
{{--            </div>--}}
    @endrole

    @if(!Auth::user()->hasRole(\App\Enums\UserRole::AFFILIATE))
    <a class="block sm:flex items-center sm:justify-between p-4 mb-8 text-sm font-semibold text-white bg-primary glass shadow-md focus:outline-none focus:shadow-outline-purple my-6" href="{{ route('bundle.checkout') }}" target="_blank" >
        <div class="block sm:flex items-center text-center">
            <svg class="w-5 h-5 mx-auto sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <span class="text-center">Buy <span class="text-accent">Share and Earn Bundle</span> to become a Pro Affiliate</span>
        </div>
        <span class="glass mt-4 sm:mt-auto block text-center link sm:link-none">Buy Now &RightArrow;</span>
    </a>
    @endif


    <div class="card rounded-none mt-10 min-h-[25rem] sm:min-h-[30rem] h-80" id="user_transaction_chart"></div>

</div>

@push('styles')
    <style>
        #user_transaction_chart{
            height: 15rem;
        }
        @media screen and (min-width:991px){
            #user_transaction_chart{
            height: 30rem;
        }
        }
    </style>
@endpush
@push('scripts')
<!-- Charting library -->
<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<!-- Your application script -->

<script>
    const chart = new Chartisan({
      el: '#user_transaction_chart',
      url: "@chart('user_transaction_chart')",
      hooks: new ChartisanHooks()
    .legend()
    .colors()
    // .datasets(['line', 'bar'])
    .tooltip(),
    });
  </script>
@endpush

</x-account-layout>
