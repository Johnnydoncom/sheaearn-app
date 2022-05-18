<x-account-layout>
    <x-slot name="title">Account Settings</x-slot>

    <div class="">
    <!-- start::Stats -->
        <h3 class="font-bold text-lg sm:text-xl">Request Withdraw</h3>
        <div class="divider mt-0"></div>

        <div class="flex flex-col justify-center items-center py-10">
            <p class="text-gray-400 text-sm mb-2">Available Balance</p>
            <h2 class="text-3xl font-bold">{{  app_money_format($withdrawable) }}</h2>
        </div>

       <div class="max-w-xl mx-auto">
           @if($canWithdraw)
           <form method="POST" action="{{ route('account.withdraw.store') }}" class="">
               @csrf
               <x-floating-input id="amount" :label="__('Amount *')" name="amount" wrapperClass="mb-8" type="text" placeholder="__('Amount')" required autofocus />

               <x-button class="btn btn-secondary btn-block">{{ __('Submit Request') }}</x-button>
           </form>
           @endif

           <div class="uppercase text-xs mt-8">
               <div class="flex justify-between items-center w-full">
                   <h2 class="uppercase sm:font-bold sm:text-xl">Payment Information</h2>
                   @if($payment_information)
                       <a href="{{ route('account.settings.index') }}" class="text-primary">Update Bank Info</a>
                   @endif
               </div>
           </div>


           <div class="card card-body p-2">
               <div class="card bg-white rounded-sm">
                   <div class="p-0">
                       @if($payment_information)
                           <div>
                               <h2 class="font-semibold text-sm">{{$payment_information->bank_account_name }}</h2>
                               <div class="font-light text-sm w-8/12">Bank: {{$payment_information->bank_name }}</div>
                               <div class="font-light text-sm w-8/12">Acc: {{$payment_information->bank_account_no }}</div>
                               <div class="font-light text-sm w-8/12">Swift: {{$payment_information->bank_swift_code }}</div>
                               <div class="font-light text-sm mt-1">Branch: {{$payment_information->bank_branch }}</div>
                               <div class="font-light text-sm mt-1">Country: {{ ($payment_information->country->name) }}</div>
                           </div>
                       @else
                           <div>
                               <a href="{{route('account.settings.index')}}" class="text-primary py-2">
                                   Add Bank Information
                               </a>
                           </div>
                       @endif
                   </div>
               </div>
           </div>
       </div>

    </div>
</x-account-layout>
