<div class="flex space-x-1 justify-around" x-data="{showRequestModal:false}" @close-modal="showRequestModal=false">
        <a @click.prevent="showRequestModal=true" href="javascript:void(0)" class="p-1 text-primary hover:text-black rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </a>

        @include('datatables::delete', ['value' => $requestId])


        {{-- <template x-if="showRequestModal"> --}}
            <div x-show="showRequestModal" class="modal modal-open" >
                <div class="modal-box relative max-w-xl text-center">
                    <label for="my-modal-3" class="btn btn-sm btn-circle absolute right-2 top-2" @click="showRequestModal=false">✕</label>
                    <div class="py-10">
                        <h3 class="text-2xl font-bold mb-10">Withdraw Request</h3>

                        <div class="flex w-full max-w-lg mx-auto">
                            <div class="mt-2">
                                <dl>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            User Name
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $withdrawRequest->user->name }}
                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Requested Amount
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $withdrawRequest->amount }}
                                        </dd>
                                    </div>
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Payment Channel
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <p class="block"><strong>Account Name:</strong> {{ $withdrawRequest->user->payment_information->bank_account_name }}</p>
                                            <p class="block"><strong>Account No:</strong> {{ $withdrawRequest->user->payment_information->bank_account_no }}</p>
                                            <p class="block"><strong>Bank Name:</strong> {{ $withdrawRequest->user->payment_information->bank_name }}</p>
                                            <p class="block"><strong>Bank Swift Code:</strong> {{ $withdrawRequest->user->payment_information->bank_name }}</p>
                                            <p class="block"><strong>Bank Branch:</strong> {{ $withdrawRequest->user->payment_information->bank_branch }}</p>
                                            <p class="block"><strong>Country:</strong> {{ $withdrawRequest->user->payment_information->country->name }}</p>

                                        </dd>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Request Date
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $withdrawRequest->request_date }}
                                        </dd>
                                    </div>
                                    <hr>

                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" wire:ignore>
                                        <dt class="text-sm font-medium text-gray-500">
                                            Status
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <x-floating-select label="Status" class="select select-bordered w-full max-w-sm mb-5" wire:model="status">
                                                @foreach ($statuses as $index => $status)
                                                <option value="{{$index}}">{{$status}}</option>
                                                @endforeach

                                            </x-floating-select>
                                            <button class="btn btn-primary rounded" @click="$wire.updateRequest" wire:loading.class="loading" wire:target="updateRequest" wire:loading.attr="disabled">Update Status</button>
                                        </dd>
                                    </div>
                                </dl>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        {{-- </template> --}}
</div>
