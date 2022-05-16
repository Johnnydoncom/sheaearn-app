<x-app-layout>
    <x-slot name="title">Order Success</x-slot>

    <div class="min-h-screen flex justify-center items-center align-middle text-center">
        <div class="text-center inline-block">
            <x-cui-cil-check-circle class="inline-block text-success text-center w-40 h-40" size="64" />
            <div class="text-center">
                <h2 class="font-bold mb-10 text-2xl">Order completed <span class="underline">#{{$order->order_number}}</span></h2>

                <a href="{{route('index')}}" class="underline">
                Back to home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
