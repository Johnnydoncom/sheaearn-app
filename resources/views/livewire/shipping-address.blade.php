<x-slot name="title">Shipping Address</x-slot>
<div x-data="{addForm:false}" class="">
    @if($showAddForm)

    <div class="container my-10">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl sm:text-2xl">Add Address</h2>
            <button class="btn btn-outline btn-primary btn-sm" wire:click="resetForm" wire:target="resetForm" wire:loading.class="loading">Back</button>
        </div>
        <div class="divider mt-0"></div>
        <form wire:submit.prevent="store">
            <div class="grid grid-cols-1 sm:grid-cols-2 w-full gap-4">
                <x-floating-input id="firstName" wrapperClass="col-span-2 sm:col-span-1" label="First Name" type="text" placeholder="First Name" wire:model.defer="first_name" required autofocus autocomplete="first_name" />


                <x-floating-input id="lastName" wrapperClass="col-span-2 sm:col-span-1" label="Last Name" type="text" placeholder="Last Name" wire:model.defer="last_name" required autofocus autocomplete="last_name" />

                <x-floating-input id="phone" wrapperClass="col-span-2" label="Phone Number" type="tel" placeholder="+2348031478943" class="w-full" wire:model.defer="phone" autofocus autocomplete="phone" />

                <x-floating-input id="address" wrapperClass="col-span-2" label="Address" type="text" placeholder="Address" class="w-full" wire:model.defer="address" autofocus autocomplete="address" />

                <x-floating-select id="region" wrapperClass="col-span-2" label="Region" type="text" placeholder="Region" class="w-full" wire:model.lazy="state" autofocus autocomplete="state">
                    <option value="" selected>Choose state</option>
                    @foreach($states as $st)
                        <option value="{{$st->id}}">{{$st->name}}</option>
                    @endforeach
                </x-floating-select>

                <x-floating-select id="city" wrapperClass="col-span-2" label="City" type="text" placeholder="City" class="w-full" wire:model.defer="city" autofocus autocomplete="city">
                    <option value="" selected>Choose city</option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </x-floating-select>
            </div>
            <x-button class="btn btn-primary btn-block mt-8" wire:loading.attr="disabled" wire:loading.class="loading">
                <x-cui-cil-location-pin class='w-5 flex-none' />
                <span class='flex-1'>Save</span>
            </x-button>
        </form>
    </div>
    @elseif ($editingAddress)
    <div class="container my-10">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl sm:text-2xl">Update Address</h2>
            <button class="btn btn-outline btn-primary btn-sm" wire:click="resetForm" wire:target="resetForm" wire:loading.class="loading">Back</button>
        </div>
        <div class="divider mt-0"></div>
        <form wire:submit.prevent="update">
            <div class="grid grid-cols-1 sm:grid-cols-2 w-full gap-4">
                <x-floating-input id="firstName" wrapperClass="col-span-2 sm:col-span-1" label="First Name" type="text" placeholder="First Name" wire:model.defer="first_name" required autofocus autocomplete="first_name" />


                <x-floating-input id="lastName" wrapperClass="col-span-2 sm:col-span-1" label="Last Name" type="text" placeholder="Last Name" wire:model.defer="last_name" required autofocus autocomplete="last_name" />

                <x-floating-input id="phone" wrapperClass="col-span-2" label="Phone Number" type="tel" placeholder="+2348031478943" class="w-full" wire:model.defer="phone" autofocus autocomplete="phone" />

                <x-floating-input id="address" wrapperClass="col-span-2" label="Address" type="text" placeholder="Address" class="w-full" wire:model.defer="address" autofocus autocomplete="address" />

                <x-floating-select id="region" wrapperClass="col-span-2" label="Region" type="text" placeholder="Region" class="w-full" wire:model.lazy="state" autofocus autocomplete="state">
                    <option value="" selected>Choose state</option>
                    @foreach($states as $st)
                        <option value="{{$st->id}}">{{$st->name}}</option>
                    @endforeach
                </x-floating-select>

                <x-floating-select id="city" wrapperClass="col-span-2" label="City" type="text" placeholder="City" class="w-full" wire:model.defer="city" autofocus autocomplete="city">
                    <option value="" selected>Choose city</option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </x-floating-select>
            </div>
            <x-button class="btn btn-primary btn-block mt-8" wire:loading.attr="disabled" wire:loading.class="loading">
                <x-cui-cil-location-pin class='w-5 flex-none' />
                <span class='flex-1'>Save</span>
            </x-button>
        </form>
    </div>
    @else
        <div class="container  mb-10">
                <button wire:click.prevent="$set('showAddForm', true)" wire:loading.class="loading" class="btn btn-link btn-block card rounded-none hover:no-underline">
                    Add a New Address
                </button>
                <div class="flex justify-between items-center border-b mb-4">
                    <h2 class="px-2 py-2 text-sm uppercase">Your address </h2>
                </div>

                @foreach($addresses as $key => $addr)
                <div class="mb-2 rounded-sm shadow-md relative mx-2 px-2 pb-0">
                    <div class="flex justify-between">
                        <h2 class="font-semibold text-sm sm:text-lg">{{ $addr->name }}</h2>
                        <button class="btn btn-outline btn-primary btn-sm" wire:click.prevent="edit({{ $addr->id}})" wire:loading.class="loading" wire:target="edit({{ $addr->id}})">
                        Edit
                        </button>
                    </div>

                    <div class="font-light text-sm w-8/12">{{$addr->address}} {{$addr->city->name}} - {{$addr->state->name}}, {{$addr->country->name}}</div>
                    <div class="font-light text-sm mt-1">{{ $addr->phone }}</div>
                    <div class="divider divider-x my-0"></div>
                    <div class="text-center">
                        <button class="btn btn-link" wire:loading.class="loading" wire:target="selectAddress({{$addr->id}})" wire:click="selectAddress({{$addr->id}})">Select this Address</button>
                    </div>
                </div>
                @endforeach
        </div>

    @endif
</div>
