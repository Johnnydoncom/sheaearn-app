<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-card class="card shadow-xl">
        <x-slot name="title">
            <div class="flex justify-between items-center mb-2">
                <h5 class="text-gray-900 text-xl leading-tight font-medium ">Add Category</h5>
                @if($editing)
                    <x-button class="btn-primary btn-block" wire:click="resetForm()">Add New</x-button>
                @endif
            </div>
        </x-slot>
        <hr>

        <form wire:submit.prevent="store">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="form-control mb-2 mt-4">
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" wire:model.defer="name" name="name" :value="old('name')" required autofocus />
                @error('name')  <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
            </div>

            <div class="py-6 form-control" wire:ignore>
                <x-label for="description" :value="__('Description')" />
                <x-textarea wire:model.defer="description" placeholder="Type anything you want..." />
            </div>


            <x-button type="submit" class="btn-primary btn-block mt-4">
                @if($editing)
                    Update
                @else
                    Publish
                @endif
            </x-button>
        </form>
    </x-card>

    <x-card class="card shadow-xl">
        <x-slot name="title"><h5 class="text-gray-900 text-xl leading-tight font-medium mb-2">Category List</h5></x-slot>
        <hr>

        <table class="w-full whitespace-nowrap mb-8">
            <thead class="bg-secondary text-gray-100 font-bold">
                <td class="py-2 pl-2">Name</td>
                <td class="py-2 pl-2">Entries</td>
                <td class="py-2 pl-2"></td>
            </thead>
            <tbody class="text-sm">
            @foreach($categories as $cat)
            <tr class="bg-gray-100 hover:bg-primary hover:bg-opacity-20 transition duration-200 @if($loop->even) bg-gray-200 @else bg-gray-100 @endif">
                <td class="py-3 pl-2 capitalize">
                    {{ $cat->name }}
                </td>
                <td class="py-3 pl-2">
                    {{ $cat->entries->count() }}
                </td>
                <td class="py-3 pl-2 flex items-center space-x-2">
                    <button wire:click.prevent="editRecord({{$cat->id}})" wire:loading.attr="disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                    <a href="#" wire:click="deleteRecord({{$cat->id}})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 hover:text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </a>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </x-card>
</div>
