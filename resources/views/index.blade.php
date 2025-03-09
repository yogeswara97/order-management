<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- METRICS --}}
    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
        <!-- Metric Card 1: Total Users -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <i class="fas fa-inbox text-blue-500"></i>
            </div>

            <div class="mt-6 flex items-end justify-between">
                <div>
                    <span class="text-lg font-semibold text-gray-600">New Order</span>
                    <h4 class="mt-2 text-xl font-bold text-gray-800">
                        {{ $newOrderCount }}
                    </h4>
                </div>
            </div>
        </div>

        <!-- Metric Card 1: Total Users -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <i class="fa fa-file-invoice text-blue-500"></i>
            </div>

            <div class="mt-6 flex flex-col items-start justify-between">
                <div class="flex items-center gap-4">
                    <span class="text-lg font-semibold text-gray-600">Revenue Month</span>
                    @php
                        $status = $percentageMonth['status'];
                        $percentage = $percentageMonth['percentage'];
                        $class = '';
                        $icon = '';

                        if ($status === 'up') {
                            $class = 'bg-green-100 text-green-600';
                            $icon = 'fas fa-arrow-up';
                        } elseif ($status === 'down') {
                            $class = 'bg-red-100 text-red-600';
                            $icon = 'fas fa-arrow-down';
                        } elseif ($status === 'flat') {
                            $class = 'bg-gray-100 text-gray-600';
                            $icon = 'fas fa-arrows-h';
                        }
                    @endphp

                    <span
                        class="flex items-center gap-1 rounded-full py-1 pl-2 pr-3 text-sm font-medium {{ $class }}">
                        <i class="{{ $icon }}"></i>
                        {{ $percentage }}%
                    </span>

                </div>

                <h4 id="revenueYear" class="mt-2 text-lg font-bold text-gray-800">
                    {{ format_currency($revenueCurrentMonth, 'IDR', 'id_ID') }}
                </h4>
            </div>
        </div>

        <!-- Metric Card 2: Active Sessions -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <i class="fa fa-file-invoice text-blue-500"></i>
            </div>

            <div class="mt-6 flex flex-col items-start justify-between">
                <div class="flex items-center gap-4">
                    <span class="text-lg font-semibold text-gray-600">Revenue Year</span>
                    @php
                        $status = $percentageYear['status'];
                        $percentage = $percentageYear['percentage'];
                        $class = '';
                        $icon = '';

                        if ($status === 'up') {
                            $class = 'bg-green-100 text-green-600';
                            $icon = 'fas fa-arrow-up';
                        } elseif ($status === 'down') {
                            $class = 'bg-red-100 text-red-600';
                            $icon = 'fas fa-arrow-down';
                        } elseif ($status === 'flat') {
                            $class = 'bg-gray-100 text-gray-600';
                            $icon = 'fas fa-arrows-h';
                        }
                    @endphp

                    <span
                        class="flex items-center gap-1 rounded-full py-1 pl-2 pr-3 text-sm font-medium {{ $class }}">
                        <i class="{{ $icon }}"></i>
                        {{ $percentage }}%
                    </span>
                </div>

                <h4 id="revenueYear" class="mt-2 text-lg font-bold text-gray-800">
                    {{ format_currency($revenueCurrentYear, 'IDR', 'id_ID') }}
                </h4>
            </div>
        </div>


        <!-- Metric Card 3: Revenue -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <i class="fas fa-users text-blue-500"></i>
            </div>

            <div class="mt-6 flex items-end justify-between">
                <div>
                    <span class="text-lg font-semibold text-gray-600">Total Customers</span>
                    <h4 class="mt-2 text-xl font-bold text-gray-800">
                        {{ $totalCustomers }}
                    </h4>
                </div>
            </div>
        </div>
    </div>


    <div class=" gap-4 mb-4 flex flex-col xl:flex-row">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 w-full xl:w-2/3 ">
            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                        <i class="fas fa-inbox text-blue-800"></i>
                    </div>
                    <div>
                        <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Latest order</h5>
                        <p class="text-sm font-normal text-gray-500">Latest order</p>
                    </div>
                </div>
            </div>
            <x-table :headers="['Customer Name', 'Status', 'Total', 'Action']">
                @foreach ($orders as $order)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <td
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap {{ $order->customer->name ?? 'text-red-600' }} ">
                            {{ $order->customer->name ?? 'No customer' }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <span
                                class=" flex items-center justify-center p-2  rounded-md
                                @if ($order->status == 'new') bg-blue-400 text-blue-950 bg-opacity-60
                                @elseif ($order->status == 'quotation')
                                    bg-yellow-400 text-yellow-950 bg-opacity-60
                                @elseif ($order->status == 'invoice')
                                    bg-green-400 text-green-950 bg-opacity-60 @endif
                            ">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ format_currency($order->grand_total, $order->currency, 'id_ID') }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex items-center gap-2">
                            <a href="{{ route('order.show', $order->id) }}"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-gray-600 border border-transparent rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('order.edit', $order->id) }}"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <i class="fas fa-pencil"></i>
                            </a>
                        </td>

                    </tr>
                @endforeach
            </x-table>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 w-full xl:w-1/3">

            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                        <i class="fas fa-chart-pie text-blue-800"></i>
                    </div>
                    <div>
                        <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Customers</h5>
                        <p class="text-sm font-normal text-gray-500">Member & Common</p>
                    </div>
                </div>
            </div>

            <!-- Line Chart -->
            <div class="py-6" id="pie-chart" class="z-10"></div>

        </div>

    </div>

    {{-- Chart --}}
    <div class="max-w-full w-full bg-white border border-gray-200 rounded-lg shadow-sm p-4 md:p-6">
        <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                    <i class="fas fa-chart-line text-blue-800"></i>
                </div>
                <div>
                    <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Revenue Chart</h5>
                    <p class="text-sm font-normal text-gray-500">Monthly Revenue for {{ $year }}</p>
                </div>
            </div>

            <div class="flex items-center justify-center gap-4">
                <!-- Previous Button -->
                <a href="{{ route('index', ['year' => $year - 1]) }}" class="button-mini-show flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <!-- Year Display -->
                <span class="text-gray-900 font-bold text-lg">
                    {{ $year }} <!-- Display the current year -->
                </span>

                <!-- Next Button -->
                <a href="{{ route('index', ['year' => $year + 1]) }}" class="button-mini-show flex items-center gap-2">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div id="revenue-chart" class="text-gray-900"></div>

    </div>



    @push('scripts')
        <script src="{{ asset('js/apexcart.js') }}"></script>
        <script>
            const options = {
                colors: ["#1A56DB"],
                series: [{
                    name: "Monthly Revenue",
                    data: @json($monthlyRevenue),
                }, ],
                chart: {
                    type: "bar",
                    height: "320px",
                    fontFamily: "Inter, sans-serif",
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "70%",
                        borderRadiusApplication: "end",
                        borderRadius: 8,
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: "darken",
                            value: 1,
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["#1A56DB"],
                },
                grid: {
                    show: false,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -14
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: false,
                },
                xaxis: {
                    floating: false,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal text-gray-500'
                            // color: '#4B5563'
                        }
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: true,
                    labels: {
                        show: true,
                        formatter: function(value) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(value);
                        },
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal text-gray-500'
                        }
                    },
                },

                fill: {
                    opacity: 1,
                },
            }

            if (document.getElementById("revenue-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("revenue-chart"), options);
                chart.render();
            }
        </script>

        <script>
            const customerPercentages = @json($customerPercentage);

            const getChartOptions = () => {
                return {
                    series: [parseFloat(customerPercentages['member']), parseFloat(customerPercentages['common'])],
                    colors: ["#1C64F2", "#16BDCA"],
                    chart: {
                        height: 420,
                        width: "100%",
                        type: "pie",
                    },
                    stroke: {
                        colors: ["white"],
                        lineCap: "",
                    },
                    plotOptions: {
                        pie: {
                            labels: {
                                show: true,
                            },
                            size: "100%",
                            dataLabels: {
                                offset: -25
                            }
                        },
                    },
                    labels: ["Members", "Common"],
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                        },
                    },
                    legend: {
                        position: "bottom",
                        fontFamily: "Inter, sans-serif",
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return value + "%"
                            },
                        },
                    },
                    xaxis: {
                        labels: {
                            formatter: function(value) {
                                return value + "%"
                            },
                        },
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                    },
                }
            }

            if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
                chart.render();
            }
        </script>
    @endpush
</x-layout>
