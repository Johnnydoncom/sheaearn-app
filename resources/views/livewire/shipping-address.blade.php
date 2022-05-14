<x-slot name="title">Shipping Address</x-slot>
<div x-data="{addForm:false}">
    @if($showAddForm)

    <div class="container">
        <form wire:submit.prevent="addAddress">
            <div class="grid grid-cols-1 sm:grid-cols-2 w-full gap-4">
                <x-floating-input id="firstName" wrapperClass="col-span-2 sm:col-span-1" label="First Name" type="text" placeholder="First Name" wire:model.defer="first_name" required autofocus autocomplete="first_name" />


                <x-floating-input id="lastName" wrapperClass="col-span-2 sm:col-span-1" label="Last Name" type="text" placeholder="Last Name" wire:model.defer="last_name" required autofocus autocomplete="last_name" />

                <x-floating-input id="phone" wrapperClass="col-span-2" label="Phone Number" type="tel" placeholder="+2348031478943" class="w-full" wire:model.defer="phone" autofocus autocomplete="phone" />

                <x-floating-input id="address" wrapperClass="col-span-2" label="Address" type="text" placeholder="Address" class="w-full" wire:model.defer="address" autofocus autocomplete="address" />

                <x-floating-select id="region" wrapperClass="col-span-2" label="Region" type="text" placeholder="Region" class="w-full" wire:model.defer="region" autofocus autocomplete="region">
                    @foreach($statesData as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                </x-floating-select>

                <x-floating-select id="city" wrapperClass="col-span-2" label="City" type="text" placeholder="City" class="w-full" wire:model.defer="city" autofocus autocomplete="city">
                    @foreach($citiesData as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </x-floating-select>


{{--            <div class="form-control mt-4">--}}
{{--                <BreezeSelect id="city" label="City" :options="citiesData" placeholder="City" class="mt-1 block w-full" v-model="form.city" required autofocus />--}}
{{--            </div>--}}

{{--            <div class="form-control mt-4">--}}
{{--                <BreezeButton class="btn-primary btn-block" :class="{ 'loading': form.processing }" :disabled="form.processing">--}}
{{--                    <mdicon name="map-marker" class='w-5 flex-none' /> <span class='flex-1'>Save</span>--}}
{{--                </BreezeButton>--}}
{{--            </div>--}}
            </div>
        </form>
    </div>
    @else
    <a href="{{route('checkout.shipping.add')}}" wire:click.prevent="$set('showAddForm', true)" class="btn btn-link btn-block card bg-white hover:bg-white hover:no-underline">
    Add a New Address
    </a>
    <div class="flex justify-between items-center">
        <h2 class="px-2 py-2 text-sm uppercase">Your address </h2>
    </div>

    @foreach($addresses as $key => $address)
    <div  class="mb-2 rounded-sm shadow-md relative mx-2 pb-0">
        <div class="flex justify-between">
            <h2 class="font-semibold text-sm">{{ $address->name }}</h2>
            <Link class="btn btn-outline btn-primary btn-sm" :href="route('checkout.shipping.edit', address.id)">
            Edit
            </Link>
        </div>

        <div class="font-light text-sm w-8/12">{{$address->address}} {{$address->city->name}} - {{$address->state->name}}, {{$address->country->name}}</div>
        <div class="font-light text-sm mt-1">{{ $address->phone }}</div>
        <div class="divider divider-x my-0"></div>
        <div class="text-center">
            <button class="btn btn-link" wire:loading.class="loading" wire:click="selectAddress($address->id)">Select this Address</button>
        </div>
    </div>
    @endforeach

    @endif
</div>
