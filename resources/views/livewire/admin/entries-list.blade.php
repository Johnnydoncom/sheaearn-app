<div x-data="{ filter: false }" class="bg-white rounded-lg py-6 overflow-x-scroll custom-scrollbar">
    <h4 class="text-xl font-semibold">Posts Table</h4>
    <div class="mt-8 mb-3 flex flex-col md:flex-row items-start md:items-center md:justify-between">
        <div class="flex items-center justify-center space-x-4">
            <form class="relative flex items-center">
                <input
                    type="search"
                    name="input_search_without_btn"
                    id="input_search_without_btn"
                    wire:model="search"
                    class="flex-1 py-0.5 pl-10 border-gray-300 focus:outline-none focus:ring-0 focus:border-gray-300"
                    placeholder="Search..."
                >
                <span class="absolute left-2 bg-transparent flex items-center justify-center" @click="show = !show">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </span>
            </form>

        </div>
        <div class="mt-4 md:mt-0">
            <form>
                <label>Order By:</label>
                <select class="text-sm py-0.5 ml-1" wire:model="orderBy">
                    <option></option>
                    <option value="title@asc">Title</option>
                    <option value="title@desc">Title DESC</option>
                    <option value="created_at@asc">Date</option>
                    <option value="created_at@desc">Date DESC</option>
                </select>
            </form>
        </div>
    </div>
    <table class="w-full whitespace-nowrap mb-8">
        <thead class="bg-secondary text-gray-100 font-bold">
{{--            <td></td>--}}
            <td class="py-2 pl-2">Title</td>
            <td class="py-2 pl-2">Sticky</td>
            <td class="py-2 pl-2">Status</td>
            <td class="py-2 pl-2">Date</td>
            <td class="py-2 pl-2"></td>
        </thead>
        <tbody class="text-sm">
        @foreach($entries as $entry)
        <tr class="bg-gray-100 hover:bg-primary hover:bg-opacity-20 transition duration-200 @if($loop->even) bg-gray-200 @else bg-gray-100 @endif">
{{--            <td class="py-3 pl-2">--}}
{{--                <input type="checkbox" class="rounded focus:ring-0 checked:bg-red-500 ml-2">--}}
{{--            </td>--}}
            <td class="py-3 pl-2 capitalize">
                {{ $entry->title }}
            </td>
            <td class="py-3 pl-2">
                @if($entry->sticky) <span class="bg-green-500 px-1.5 py-0.5 rounded-lg text-gray-100">Sticky</span> @endif
            </td>
            <td class="py-3 pl-2">
                @if($entry->published) <span class="bg-green-500 px-1.5 py-0.5 rounded-lg text-gray-100">Published</span> @else <span class="bg-red-500 px-1.5 py-0.5 rounded-lg text-gray-100">Published</span>@endif
            </td>
            <td class="py-3 pl-2">
{{--                Sep 30, 2021--}}
                {{ $entry->created_at->format('F j, Y') }}
            </td>
            <td class="py-3 pl-2 flex items-center space-x-2">
                <a href="{{ $entry->entry_url }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary hover:text-primary-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>
                <a href="{{ route('admin.entries.edit', $entry->id) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </a>
                <a href="#" wire:click="deleteRecord({{$entry->id}})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 hover:text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </a>
            </td>
        </tr>
        @endforeach

        </tbody>
        <tfoot class="pt-6">
            <tr >
                <td class="pt-6">
                    {{ $entries->links() }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
