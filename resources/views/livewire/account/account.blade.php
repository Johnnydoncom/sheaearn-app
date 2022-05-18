    <div>
        <!-- start::Stats -->
        <div class="grid grid-cols-3 md:grid-cols-2 xl:grid-cols-3 gap-1 sm:gap-6">
            <div class="px-2 sm:px-6 py-2 sm:py-6 bg-white rounded-lg shadow sm:shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="font-normal sm:font-bold text-xs sm:text-sm text-indigo-600">All Time Earning</span>
                </div>
                <div class="flex items-center justify-between mt-2 sm:mt-6">
                    <div class="hidden sm:block">
                        <svg class="w-4 h-4 sm:w-12 2xl:w-16 sm:h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-indigo-600 border border-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-end">
                            <span class="text-sm sm:text-2xl 2xl:text-3xl font-bold">{{ app_money_format($allTimeEarning) }}</span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-2 sm:px-6 py-2 sm:py-6 bg-white rounded-lg shadow sm:shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="font-normal sm:font-bold text-xs sm:text-sm text-indigo-600">Sales Earning</span>
                </div>
                <div class="flex items-center justify-between mt-2 sm:mt-6">
                    <div class="hidden sm:block">
                        <svg class="w-4 h-4 sm:w-12 2xl:w-16 sm:h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-indigo-600 border border-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-end">
                            <span class="text-sm sm:text-2xl 2xl:text-3xl font-bold">{{ app_money_format($salesEarning) }}</span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-2 sm:px-6 py-2 sm:py-6 bg-white rounded-lg shadow sm:shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="font-normal sm:font-bold text-xs  sm:text-sm text-indigo-600">Social Earning</span>
                </div>
                <div class="flex items-center justify-between mt-2 sm:mt-6">
                    <div class="hidden sm:block">
                        <svg class="w-4 h-4 sm:w-12 2xl:w-16 sm:h-12 2xl:h-16 p-1 2xl:p-3 bg-indigo-400 bg-opacity-20 rounded-full text-indigo-600 border border-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-end">
                            <span class="text-sm sm:text-2xl 2xl:text-3xl font-bold">{{ app_money_format($socialEarning) }}</span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end::Stats -->

        {{-- <div class="shadow rounded p-4 border bg-white" style="height: 32rem;"> --}}
            {{-- <livewire:livewire-area-chart
                key="{{ $areaChartModel->reactiveKey() }}"
                :area-chart-model="$areaChartModel"
            /> --}}
        {{-- </div> --}}

        <div id="user_transaction_chart" style="height: 300px;"></div>

    </div>


@push('scripts')
<!-- Charting library -->
<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<!-- Your application script -->

<script>
    const chart = new Chartisan({
      el: '#user_transaction_chart',
      url: "@chart('user_transaction_chart')",
      hooks: new ChartisanHooks()
    .legend()
    .colors()
    // .datasets(['line', 'bar'])
    .tooltip(),
    });
  </script>
@endpush

