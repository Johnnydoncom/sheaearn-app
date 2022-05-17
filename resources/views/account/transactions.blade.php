<x-account-layout>
    <x-slot name="title">Wallet Transactions</x-slot>

    <!-- start::Table -->
    <div class="bg-white rounded-lg px-8 py-6 overflow-x-scroll custom-scrollbar">
        <h4 class="text-xl font-semibold">Wallet Transactions</h4>
        <table class="w-full my-8 whitespace-nowrap">
            <thead class="bg-secondary text-gray-100 font-bold">
                <td class="py-2 pl-2">Trans Type</td>
                <td class="py-2 pl-2">Amount</td>
                <td class="py-2 pl-2">Description</td>
                <td class="py-2 pl-2">Date</td>
            </thead>
            <tbody class="text-sm">
            @forelse($transactions as $transaction)
                <tr class="@if($loop->odd) bg-gray-100 @else bg-gray-200 @endif hover:bg-primary hover:bg-opacity-20 transition duration-200">
                    <td class="py-3 pl-2">
                        {{ucwords($transaction->type)}}
                    </td>
                    <td class="py-3 pl-2">
                        {{app_money_format($transaction->amount)}}
                    </td>
                    <td class="py-3 pl-2">
                        {{ $transaction->meta['description'] }}
                    </td>
                    <td class="py-3 pl-2">
                        {{ $transaction->created_at->format('F j, Y') }}
                    </td>
                </tr>
            @empty
                <tr class="bg-gray-100 hover:bg-primary hover:bg-opacity-20 transition duration-200">
                    <td class="py-3 pl-2 text-center" colspan="6">
                        No data
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
    <!-- end::Table -->
</x-account-layout>
