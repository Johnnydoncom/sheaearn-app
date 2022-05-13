<x-slot name="title">Shipping Address</x-slot>
<div>
    @if($showAddForm)
    <div>
        <form wire:submit.prevent="addAddress" class="space-y-6">

                <x-floating-input id="firstName" label="First Name" type="text" placeholder="First Name" class="mt-1 block w-full" v-model="form.first_name" required autofocus autocomplete="first_name" />


                <x-floating-input id="lastName" label="Last Name" type="text" placeholder="Last Name" class="mt-1 block w-full" v-model="form.last_name" required autofocus autocomplete="last_name" />


{{--            <div class="form-control mt-4">--}}
{{--                <x-input id="phone" label="Phone Number" type="tel" placeholder="+2348031478943" class="mt-1 block w-full" v-model="form.phone" autofocus autocomplete="phone" />--}}
{{--            </div>--}}

{{--            <div class="form-control mt-4">--}}
{{--                <BreezeInput id="address" label="Address" type="text" placeholder="Address" class="mt-1 block w-full" v-model="form.address" required autofocus />--}}
{{--            </div>--}}

{{--            <div class="form-control mt-4">--}}
{{--                <BreezeSelect id="region" label="Region" :options="statesData" placeholder="Region" class="mt-1 block w-full" v-model="form.region" @change="getCities" required autofocus />--}}
{{--            </div>--}}

{{--            <div class="form-control mt-4">--}}
{{--                <BreezeSelect id="city" label="City" :options="citiesData" placeholder="City" class="mt-1 block w-full" v-model="form.city" required autofocus />--}}
{{--            </div>--}}

{{--            <div class="form-control mt-4">--}}
{{--                <BreezeButton class="btn-primary btn-block" :class="{ 'loading': form.processing }" :disabled="form.processing">--}}
{{--                    <mdicon name="map-marker" class='w-5 flex-none' /> <span class='flex-1'>Save</span>--}}
{{--                </BreezeButton>--}}
{{--            </div>--}}

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
