<x-admin-layout>
    <x-slot name="title">{{ __('Users') }}</x-slot>

    <div>
        {{-- <livewire:entries-table /> --}}

        {{--        <livewire:datatable model="App\Models\User" name="all-users" />--}}
        <livewire:admin.users-table/>
    </div>

</x-admin-layout>
