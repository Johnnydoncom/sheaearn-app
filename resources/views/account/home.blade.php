<x-account-layout>
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




    <div class="bg-gray-800 text-gray-500 rounded shadow-xl py-5 px-5 w-full lg:w-1/2" x-data="{chartData:chartData()}" x-init="chartData.fetch()">
        <div class="flex flex-wrap items-end">
            <div class="flex-1">
                <h3 class="text-lg font-semibold leading-tight">Income</h3>
            </div>
            <div class="relative" @click.away="chartData.showDropdown=false">
                <button class="text-xs hover:text-gray-300 h-6 focus:outline-none" @click="chartData.showDropdown=!chartData.showDropdown">
                    <span x-text="chartData.options[chartData.selectedOption].label"></span><i class="ml-1 mdi mdi-chevron-down"></i>
                </button>
                <div class="bg-gray-700 shadow-lg rounded text-sm absolute top-auto right-0 min-w-full w-32 z-30 mt-1 -mr-3" x-show="chartData.showDropdown" style="display: none;" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4">
                    <span class="absolute top-0 right-0 w-3 h-3 bg-gray-700 transform rotate-45 -mt-1 mr-3"></span>
                    <div class="bg-gray-700 rounded w-full relative z-10 py-1">
                        <ul class="list-reset text-xs">
                            <template x-for="(item,index) in chartData.options">
                                <li class="px-4 py-2 hover:bg-gray-600 hover:text-white transition-colors duration-100 cursor-pointer" :class="{'text-white':index==chartData.selectedOption}" @click="chartData.selectOption(index);chartData.showDropdown=false">
                                    <span x-text="item.label"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap items-end mb-5">
            <h4 class="text-2xl lg:text-3xl text-white font-semibold leading-tight inline-block mr-2" x-text="'$'+(chartData.data?chartData.data[chartData.date].total.comma_formatter():0)">0</h4>

        </div>
        <div>
            <canvas id="chart" class="w-full"></canvas>
        </div>
    </div>

</div>

    @push('styles')

        <style>
            @import url(https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css);
            @import url(https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css);
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script>
            Number.prototype.comma_formatter = function() {
                return this.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
            }

            let chartData = function(){
                return {
                    date: 'today',
                    options: [
                        {
                            label: 'Today',
                            value: 'today',
                        },
                        {
                            label: 'Last 7 Days',
                            value: '7days',
                        },
                        {
                            label: 'Last 30 Days',
                            value: '30days',
                        },
                        {
                            label: 'Last 6 Months',
                            value: '6months',
                        },
                        {
                            label: 'This Year',
                            value: 'year',
                        },
                    ],
                    showDropdown: false,
                    selectedOption: 0,
                    selectOption: function(index){
                        this.selectedOption = index;
                        this.date = this.options[index].value;
                        this.renderChart();
                    },
                    data: null,
                    fetch: function(){
                        fetch('https://cdn.jsdelivr.net/gh/swindon/fake-api@master/tailwindAlpineJsChartJsEx1.json')
                            .then(res => res.json())
                            .then(res => {
                                this.data = res.dates;
                                this.renderChart();
                            })
                    },
                    renderChart: function(){
                        let c = false;

                        Chart.helpers.each(Chart.instances, function(instance) {
                            if (instance.chart.canvas.id == 'chart') {
                                c = instance;
                            }
                        });

                        if(c) {
                            c.destroy();
                        }

                        let ctx = document.getElementById('chart').getContext('2d');

                        let chart = new Chart(ctx, {
                            type: "line",
                            data: {
                                labels: this.data[this.date].data.labels,
                                datasets: [
                                    {
                                        label: "Income",
                                        backgroundColor: "rgba(102, 126, 234, 0.25)",
                                        borderColor: "rgba(102, 126, 234, 1)",
                                        pointBackgroundColor: "rgba(102, 126, 234, 1)",
                                        data: this.data[this.date].data.income,
                                    },
                                    {
                                        label: "Expenses",
                                        backgroundColor: "rgba(237, 100, 166, 0.25)",
                                        borderColor: "rgba(237, 100, 166, 1)",
                                        pointBackgroundColor: "rgba(237, 100, 166, 1)",
                                        data: this.data[this.date].data.expenses,
                                    },
                                ],
                            },
                            layout: {
                                padding: {
                                    right: 10
                                }
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        gridLines: {
                                            display: false
                                        },
                                        ticks: {
                                            callback: function(value,index,array) {
                                                return value > 1000 ? ((value < 1000000) ? value/1000 + 'K' : value/1000000 + 'M') : value;
                                            }
                                        }
                                    }]
                                }
                            }
                        });
                    }
                }
            }
        </script>
    @endpush

</x-account-layout>
