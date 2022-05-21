<x-admin-layout>
    <!-- start::Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-bold text-sm text-indigo-600">Total Revenue</span>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div>
                    <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-indigo-600 border border-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-xl 2xl:text-3xl font-bold">{{ app_money_format($totalRevenue) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-bold text-sm text-blue-600">Total Users</span>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div>
                    <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-blue-400 bg-opacity-20 rounded-full text-blue-600 border border-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-start">
                        <span class="text-2xl 2xl:text-3xl font-bold">{{ $userCount }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-bold text-sm text-green-600">Total Products</span>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div>
                    <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-green-400 bg-opacity-20 rounded-full text-green-600 border border-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-2xl 2xl:text-4xl font-bold">{{ \App\Models\Product::count() }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-bold text-sm text-yellow-600">Total Posts</span>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div>
                    <svg class="w-12 2xl:w-16 h-12 2xl:h-16 p-1 2xl:p-3 bg-yellow-400 bg-opacity-20 rounded-full text-yellow-600 border border-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-2xl 2xl:text-4xl font-bold">{{ \App\Models\Entry::count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end::Stats -->

    <!-- start::Stats  -->
    <div class="flex flex-col xl:flex-row space-y-4 xl:space-y-0 xl:space-x-4">

        <!-- start::Project overview stats -->
        <div class="w-full xl:w-2/3 p-6 space-y-6 bg-white shadow-xl rounded-lg">
            <h4 class="text-xl font-semibold mb-4 capitalize">Recent Orders</h4>
            <section class="space-y-6">
                <table class="w-full my-8 whitespace-nowrap">
                    <thead class="bg-secondary text-gray-100 font-bold">
                    <td class="py-2 pl-2">Order ID</td>
                    <td class="py-2 pl-2">Price</td>
                    <td class="py-2 pl-2">Payment</td>
                    <td class="py-2 pl-2">Status</td>
                    <td class="py-2 pl-2">Date</td>
                    <td class="py-2 pl-2">View Details</td>
                    </thead>
                    <tbody class="text-sm">
                    @forelse($recentOrders as $order)
                        <tr class="@if($loop->odd) bg-gray-100 @else bg-gray-200 @endif hover:bg-primary hover:bg-opacity-20 transition duration-200">
                            <td class="py-3 pl-2">
                                #{{$order->order_number}}
                            </td>
                            <td class="py-3 pl-2">
                                {{$order->grand_total}}
                            </td>
                            <td class="py-3 pl-2">
                                @if($order->payment_status === 5)
                                    <span class="bg-warning px-1.5 py-0.5 rounded-lg text-gray-100">
                                    Pending
                                    </span>
                                @elseif($order->payment_status === 7)
                                    <span class="bg-red-500 px-1.5 py-0.5 rounded-lg text-gray-100">
                                    Canceled
                                </span>
                                @else
                                    <span class="bg-green-500 px-1.5 py-0.5 rounded-lg text-gray-100">
                                    Paid
                                </span>
                                @endif
                            </td>
                            <td class="py-3 pl-2">
                                @if($order->status == 'completed' || $order->status == 'delivered')
                                    <span class="bg-green-500 px-1.5 py-0.5 rounded-lg text-gray-100">
                                        {{ $order->status }}
                                    </span>
                                @else
                                    <span class="bg-secondary px-1.5 py-0.5 rounded-lg text-gray-100">
                                        {{ $order->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 pl-2">
                                {{ $order->created_at->format('F j, Y') }}
                            </td>
                            <td class="py-3 pl-2">
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-primary hover:bg-opacity-90 px-2 py-1 mr-2 text-gray-100 rounded-lg">View Details</a>
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
            </section>
        </div>
        <!-- end::Project overview stats -->

        <!-- start::Total stats -->
        <div class="w-full xl:w-1/3 p-6 space-y-6 bg-white shadow-xl rounded-lg">
            <h4 class="text-xl font-semibold mb-4 capitalize">Order stats</h4>
            <div class="grid grid-cols-2 gap-4 h-40">
                <div class="bg-green-300 bg-opacity-20 text-green-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-4xl font-bold">{{ \App\Models\Order::whereStatus(\Str::slug(config('appstore.orderstatus.completed'), '_'))->count() }}</span>
                    <span>Completed</span>
                </div>
                <div class="bg-indigo-300 bg-opacity-20 text-indigo-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-4xl font-bold">{{ \App\Models\Order::whereStatus(\Str::slug(config('appstore.orderstatus.shipped'), '_'))->count() }}</span>
                    <span>Shipped</span>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2 h-32">
                <div class="bg-yellow-300 bg-opacity-20 text-yellow-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-3xl font-bold">{{ \App\Models\Order::whereStatus(\Str::slug(config('appstore.orderstatus.order_placed'), '_'))->count() }}</span>
                    <span>Pending</span>
                </div>
                <div class="bg-blue-300 bg-opacity-20 text-blue-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-3xl font-bold">{{ \App\Models\Order::whereStatus('processing')->count() }}</span>
                    <span>Processing</span>
                </div>
                <div class="bg-red-300 bg-opacity-20 text-red-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-3xl font-bold">{{ \App\Models\Order::whereStatus(\Str::slug(config('appstore.orderstatus.canceled'), '_'))->count() }}</span>
                    <span>Canceled</span>
                </div>
            </div>
        </div>
        <!-- end::Total stats -->
    </div>
    <!-- end::Stats -->

    <!-- start::Table -->
    <div class="bg-white rounded-lg px-8 py-6 overflow-x-scroll custom-scrollbar">
        <h4 class="text-xl font-semibold">Recent Withdraw Request</h4>
        <table class="w-full my-8 whitespace-nowrap">
            <thead class="bg-secondary text-gray-100 font-bold">
            <td class="py-2 pl-2">User</td>
            <td class="py-2 pl-2">Amount</td>
            <td class="py-2 pl-2">Status</td>
            <td class="py-2 pl-2">Request Date</td>
            <td class="py-2 pl-2">Action</td>
            </thead>
            <tbody class="text-sm">
            @forelse($withdrawRequests as $order)
                <tr class="@if($loop->odd) bg-gray-100 @else bg-gray-200 @endif hover:bg-primary hover:bg-opacity-20 transition duration-200">
                    <td class="py-3 pl-2">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ \Storage::url('avatar.png') }}"  class="rounded-full w-14" />
                            </div>
                            <div class="ml-2">
                                <div class="text-sm font-medium leading-5 text-gray-900">
                                    {{$order->user->name}}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 pl-2">
                        {{ app_money_format($order->amount) }}
                    </td>
                    <td class="py-3 pl-2">
                        @if($order->status == \WithdrawStatus::PENDING)
                            <span class="bg-warning px-1.5 py-0.5 rounded-lg text-gray-100">
                                    Pending
                                    </span>
                        @elseif($order->status == \WithdrawStatus::CANCELED)
                            <span class="bg-red-500 px-1.5 py-0.5 rounded-lg text-gray-100">
                                    Rejected
                                </span>
                        @else
                            <span class="bg-green-500 px-1.5 py-0.5 rounded-lg text-gray-100">
                                    Paid
                                </span>
                        @endif
                    </td>
                    <td class="py-3 pl-2">
                        {{ $order->created_at->format('F j, Y') }}
                    </td>
                    <td class="py-3 pl-2">
                       @include('admin.withdraw.table-actions', ['id' => $id])
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


</x-admin-layout>
