<x-landing-layout>
    <x-slot name="title">Home</x-slot>

    <div class="py-12">
        <section class="max-w-6xl md:max-w-7xl mx-auto hero px-1 sm:px-12 mb-20">

            <div class="flex flex-wrap gap-x-2 items-center text-center justify-center sm:justify-start leading-none sm:text-left text-3xl sm:text-[5.288rem] font-bold px-4 font-poppins dark:text-gray-200">
                Create a <img src="{{Storage::url('secure.jpg')}}" class="h-[0.8em] rounded-full sm:mx-2 w-20 sm:w-auto"> <span class="text-primary">store,</span> mint, <span class="text-primary">and get</span> <img src="{{Storage::url('secure2.jpg')}}" class="h-[0.8em] rounded-full sm:mx-2 w-10 sm:w-auto"> <img src="{{Storage::url('secure3.jpg')}}" class="h-[0.8em] rounded-full sm:mx-1 w-14 sm:w-auto"> <span class="flex-none">collectors for your</span> <span class="text-primary mx-2"> NFTs.</span>
            </div>
        </section>

        <section class="max-w-4xl sm:mx-auto mx-2 sm:px-0 relative bg-center bg-cover rounded-3xl sm:rounded-full bg-no-repeat relative" style="background-image:  linear-gradient(180deg, rgba(41, 41, 41, 0.74), rgba(41, 41, 41, 0.74)), url('/storage/bf_banner_bg.jpg')">
{{--            <div class="absolute top-0 right-0 bottom-0 left-0 bg-gray-900/50"></div>--}}

            <div class="sm:p-28 p-10 text-white flex flex-col gap-4 justify-center items-center text-center">
                <div class="avatar relative sm:absolute sm:-top-8 sm:-right-8 rounded-full bg-white w-20 h0-20 sm:w-40 sm:h-40">
                    <img src="{{ Storage::url('avatar.png') }}" alt="Avatar">
                </div>
                <h2 class="text-lg sm:text-4xl mb-4">Let Sheaearn help you start and manage your NFT business for FREE!</h2>
                <a href="#" class="inline-block px-12 py-6 bg-primary text-white font-medium text-xl leading-snug shadow-md hover:bg-white hover:text-black hover:border-primary hover:shadow-lg focus:bg-primary focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary active:shadow-lg transition duration-150 ease-in-out sm:rounded-full rounded-3xl">Join the waitlist</a>
            </div>

            <img src="{{ Storage::url('arrow-down.svg') }}" alt="Arrow Down" class="absolute -bottom-40 -right-24 h-[16rem] hidden sm:block">
        </section>
        <section class="relative text-center py-1 sm:py-12">
            <div class="flex items-center w-full py-2 sm:py-6 mt-6 relative ">
                <div class="absolute left-0 top-0 w-10/12 sm:w-full max-w-5xl flex-grow border-t-4 border-gray-200"></div>
            </div>

            <div class="relative py-5">
                <div  class="flex flex-col items-center justify-center h-full">
                    <h2 class="text-primary text-3xl sm:text-7xl font-bold w-full">What We Offer</h2>
                    <h2 class="text-primary text-6xl sm:text-[12em] text-center font-bold absolute w-full inset-x-auto opacity-10">different</h2>
                </div>
            </div>

            <img src="{{ Storage::url('circle.svg') }}" alt="Arrow Down" class="absolute top-1/4 sm:top-1/3 -left-50 h-36 sm:h-[16rem]">

            <div class="grid grid-cols-1 sm:grid-cols-2 container">
                <div class="card p-10 text-center relative">
                    <div class="bg-white rounded-3xl mx-auto shadow-md flex items-center justify-center w-24 h-24 sm:w-36 sm:h-36">
                        <img src="{{ Storage::url('homeIcon1.svg') }}" alt="Arrow Down" class="w-24 h-24 sm:w-36 sm:h-36 object-contain object">
                    </div>
                    <div class="text-lg sm:text-4xl mt-6 dark:text-gray-200">
                        Easy-to-use platform to launch and manage your NFT business.
                    </div>
                </div>
                <div class="card p-10 text-center relative">
                    <div class="bg-white rounded-3xl mx-auto shadow-md flex items-center justify-center w-24 h-24 sm:w-36 sm:h-36">
                        <img src="{{ Storage::url('homeIcon1.svg') }}" alt="Arrow Down" class="w-24 h-24 sm:w-36 sm:h-36 object-contain object">
                    </div>
                    <div class="text-lg sm:text-4xl mt-6 dark:text-gray-200">
                        Easy-to-use platform to launch and manage your NFT business.
                    </div>
                </div>
                <div class="card p-10 text-center relative">
                    <div class="bg-white rounded-3xl mx-auto shadow-md flex items-center justify-center w-24 h-24 sm:w-36 sm:h-36">
                        <img src="{{ Storage::url('Profile.svg') }}" alt="Profile" class="w-24 h-24 sm:w-36 sm:h-36 object-contain object">
                    </div>
                    <div class="text-lg sm:text-4xl mt-6 dark:text-gray-200">
                        Inclusive Community for you to connect with collectors and other NFT enthusiasts.
                    </div>
                </div>
                <div class="card p-10 text-center relative">
                    <div class="bg-white rounded-3xl mx-auto shadow-md flex items-center justify-center w-24 h-24 sm:w-36 sm:h-36">
                        <img src="{{ Storage::url('Security.svg') }}" alt="Security" class="w-24 h-24 sm:w-36 sm:h-36 object-contain object">
                    </div>
                    <div class="text-lg sm:text-4xl mt-6 dark:text-gray-200">
                        Certificate of Authenticity for every NFT minted and sold on your store.
                    </div>
                </div>
            </div>

            <div class="relative container hidden sm:block">
                <img src="{{ Storage::url('arrow-3.svg') }}" alt="Arrow Down" class="absolute -bottom-[15em] left-4 2xl:left-0 h-[17rem] ">
            </div>
        </section>

        <section class="relative text-center py-10">
            <div class="flex items-center w-full py-0 sm:py-6 mt-6 relative ">
                <div class="absolute right-0 top-0 w-10/12 max-w-7xl flex-grow border-t-4 border-gray-200"></div>
            </div>

            <div class="relative py-10">
                <div  class="flex flex-col items-center justify-center h-full">
{{--                    <div class="absolute top-0 w-full max-w-7xl right-0 border-t-4 border-gray-400 mb-6"></div>--}}

                    <h2 class="text-primary text-3xl sm:text-7xl font-bold w-full">Who We Serve</h2>
                    <h2 class="text-primary text-6xl sm:text-[11em] text-center font-bold absolute w-full inset-x-auto opacity-10">building for</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 sm:gap-4 gap-4 sm:gap-0 container sm:mt-10">
                <div class="flex justify-center px-10 sm:p-0">
                    <div class="rounded-3xl sm:shadow-lg bg-white max-w-xs sm:max-w-sm">
                        <div class="rounded-3xl bg-primary">
                            <img src="{{ Storage::url('Creators.png') }}" alt="Creators" class="object-contain h-54 sm:h-54 lg:h-96 w-full">
                        </div>

                       <div class="py-6 text-center">
                           <h2 class="text-2xl lg:text-4xl font-bold mb-3">Creators</h2>
                           <div class="text-md lg:text-3xl px-1">Creators can now launch their stores, mint and sell NFTs in minutes.</div>

                           <img src="{{Storage::url('line-1.svg')}}" alt="Line" class="mx-auto mt-6 w-32 sm:w-auto">
                       </div>
                    </div>
                </div>
                <div class="flex justify-center px-10 sm:p-0">
                    <div class="rounded-3xl sm:shadow-lg bg-white max-w-xs sm:max-w-sm">
                        <div class="rounded-3xl bg-primary">
                            <img src="{{ Storage::url('Collectors.png') }}" alt="Collectors" class="object-contain h-54 sm:h-54 lg:h-96 w-full">
                        </div>

                        <div class="py-6 text-center">
                            <h2 class="text-2xl lg:text-4xl font-bold mb-3">Collectors</h2>
                            <div class="text-md lg:text-3xl px-1">Collectors now have more freedom to connect with their favorite Creators, get whitelisted and buy NFTs.</div>

                            <img src="{{Storage::url('line-1.svg')}}" alt="Line" class="mx-auto mt-6 w-32 sm:w-auto">
                        </div>
                    </div>
                </div>
                <div class="flex justify-center px-10 sm:p-0">
                    <div class="rounded-3xl sm:shadow-lg bg-white max-w-xs sm:max-w-sm">
                        <div class="rounded-3xl bg-primary">
                            <img src="{{ Storage::url('Affiliates.png') }}" alt="Affiliates" class="object-contain h-54 sm:h-54 lg:h-96 w-full">
                        </div>

                        <div class="py-6 text-center">
                            <h2 class="text-2xl lg:text-4xl font-bold mb-3">Affiliates</h2>
                            <div class="text-md lg:text-3xl px-1">Affiliates can also earn from referring Creators and Collectors to use Mintyplex.</div>

                            <img src="{{Storage::url('line-1.svg')}}" alt="Line" class="mx-auto mt-6 w-32 sm:w-auto">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-col items-center w-full pb-6 sm:py-6 sm:mt-6 relative flex">
                <div class="container mx-auto relative hidden sm:block">
                    <img src="{{ Storage::url('arrow-down.svg') }}" alt="Arrow Down" class="absolute -bottom-[15em] md:-right-14 h-[17rem]">
                </div>
                <div class="absolute left-0 top-20 w-10/12 container flex-grow border-t-4 border-gray-200"></div>
            </div>
        </section>
        <section class="container mt-20 sm:mt-12">
            <div class="flex justify-center bg-secondary dark:bg-brand rounded-3xl py-10 px-4 sm:px-20 sm:py-20 shadow-lg">
                <div class="text-center">
                    <h2 class="text-white text-3xl sm:text-6xl font-extrabold mb-4 text-white">Join the  waiting  list</h2>
                    <p class="text-md sm:text-4xl mb-6 leading-normal text-white">
                        Sheaearn empowers independent Creators to start and grow their NFT business effortlessly.
                    </p>
                    <p class="text-md sm:text-4xl mb-10 leading-normal text-white">
                        We are currently accepting only 2000 Creators on a first come, first served basis to join our waitlist and early Creators will be considered for our airdrop.
                    </p>
                    <div class="container flex justify-center items-center">
                        <div class="relative w-full">
                            <input type="text" class="sm:h-40 w-full sm:pl-10 sm:pr-60 pl-10 pr-10 rounded-full text-xl sm:text-3xl z-0 focus:shadow focus:outline-none" placeholder="Search anything...">
                            <div class="sm:absolute top-2 right-2 mt-2 sm:mt-auto">
                                <button class="sm:h-36 w-full sm:w-auto px-12 sm:py-5 py-3 text-white text-xl sm:text-3xl bg-primary hover:bg-primary rounded-full">Join the waitlist</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative text-center container py-10">

            <div class="relative py-10">
                <div  class="flex flex-col items-center justify-center h-full">
                    <h2 class="text-primary text-3xl sm:text-7xl font-bold w-full">Join Our</h2>
                    <h2 class="text-primary text-6xl sm:text-[11em] text-center font-bold absolute w-full inset-x-auto opacity-10">community.</h2>
                </div>
            </div>

            <div class="grid grid-cols-4 sm:grid-cols-5 gap-0 space-0 sm:gap-4 mt-10">
                <div>
                    <div class="flex justify-center">
                        <div class="rounded-full shadow-lg bg-sky-100 max-w-sm p-2 sm:p-4">
                            <img src="{{ Storage::url('Facebook.png') }}" alt="Facebook" class="object-contain h-8 sm:h-24 w-full">
                        </div>
                    </div>
                </div>
               <div>
                   <div class="flex justify-center">
                       <div class="rounded-full shadow-lg bg-sky-100 max-w-sm p-2 sm:p-4">
                           <img src="{{ Storage::url('Twitter.png') }}" alt="Facebook" class="object-contain h-8 sm:h-24 w-full">
                       </div>
                   </div>
               </div>
               <div>
                   <div class="flex justify-center">
                       <div class="rounded-full shadow-lg bg-sky-100 max-w-sm p-2 sm:p-4">
                           <img src="{{ Storage::url('Telegram.png') }}" alt="Facebook" class="object-contain h-8 sm:h-24 w-full">
                       </div>
                   </div>
               </div>
               <div>
                   <div class="flex justify-center">
                       <div class="rounded-full shadow-lg bg-gray-200 max-w-sm p-2 sm:p-4">
                           <img src="{{ Storage::url('Discord.png') }}" alt="Facebook" class="object-contain h-8 sm:h-24 w-full">
                       </div>
                   </div>
               </div>
               <div class="absolute sm:relative -left-10 top-1/4 sm:top-auto">
                   <div class="flex justify-center p-2 sm:p-4">
                       <div class="rounded-full shadow-lg bg-sky-100 max-w-sm p-4">
                           <img src="{{ Storage::url('avatar-1.png') }}" alt="Facebook" class="object-contain h-14 sm:h-24 w-full">
                       </div>
                   </div>
               </div>

            </div>

            <img src="{{ Storage::url('arrow-4.svg') }}" alt="Arrow Down" class="absolute inset-y-1/2 -right-14 h-24 hidden sm:block">
        </section>
    </div>
    <footer class="text-center dark:text-gray-400">
        <p class="text-center text-2xl py-10">{{ date('Y') }}. All Rights Reserved</p>
    </footer>
</x-landing-layout>
