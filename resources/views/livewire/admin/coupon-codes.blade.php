<div>
    <div class="card bg-white" x-data="{count: @entangle('count'), value: @entangle('value'), showForm:false}" @coupon-generated.window="showForm=false">
        <div class="card-body">
            <div class="text-right">
                <x-button class="btn btn-primary btn-sm align-self-end" @click.prevent="showForm= !showForm">Generate Coupon</x-button>
                <div x-show="showForm" class="text-left mt-4" x-transition>
                    <form method="post" wire:submit.prevent="store">
                        @csrf
                       <div class="grid grid-cols-3 gap-2 items-end">
                           <div class="form-control">
                               <x-label>No of codes</x-label>
                               <x-input wire:model.defer="count" x-model="count" required />
                           </div>
                           <div class="form-control">
                               <x-label>Value</x-label>
                               <x-input wire:model.defer="value" x-model="value" />
                           </div>
                           <div class="">
                               <x-button class="btn btn-primary" wire:loading.class="loading" wire:target="store">Generate</x-button>
                           </div>
                       </div>
                    </form>
                </div>
            </div>
            <h3 class="font-semibold text-2xl">Coupon Codes</h3>
            <div>
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-secondary text-gray-100 font-bold">
                        <td class="py-2 pl-2">ID</td>
                        <td class="py-2 pl-2">Code</td>
                        <td class="py-2 pl-2">Status</td>
                        <td class="py-2 pl-2">Action</td>
                    </thead>
                    <tbody class="text-sm">
                    @forelse($coupons as $c)
                        <tr class="@if($loop->odd) bg-gray-100 @else bg-gray-200 @endif hover:bg-primary hover:bg-opacity-20 transition duration-200">
                            <td class="py-3 pl-2">
                                #{{$c->id}}
                            </td>
                            <td class="py-3 pl-2">
                                {{$c->code}}
                            </td>
                            <td class="py-3 pl-2">
                                {{$c->usages_left}}
                            </td>
                            <td class="py-3 pl-2 flex gap-2 justify-end">
                                @if($c->usages_left > 0)
                                <button wire:click.prevent="deleteCoupon({{$c->id}})" wire:loading.class="loading" wire:target="deleteCoupon({{$c->id}})" class="btn btn-xs btn-error text-white rounded-lg border-none shadow-md rounded-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete
                                </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center">No data</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot class="">
                    <tr>
                        <td colspan="3">
                            <div class="mt-4">{{ $coupons->links() }}</div></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('coupon-generated', event => {
        })
    </script>
</div>
