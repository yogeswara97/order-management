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
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 w-full xl:w-2/3 overflow-x-scroll">
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

        {{-- CUTSOMER PIE CHART --}}
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

            <div class="py-6" id="customer-pie-chart" class="z-10"></div>

        </div>

    </div>

    {{-- Chart --}}

    {{-- REVENUE CHART --}}
    <div class="mb-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
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
                    <a href="{{ route('index', ['year' => $year - 1]) }}"
                        class="button-mini-show flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>

                    <!-- Year Display -->
                    <span class="text-gray-900 font-bold text-lg">
                        {{ $year }} <!-- Display the current year -->
                    </span>

                    <!-- Next Button -->
                    <a href="{{ route('index', ['year' => $year + 1]) }}"
                        class="button-mini-show flex items-center gap-2">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div id="revenue-chart" class="text-gray-900"></div>

        </div>
    </div>

    {{-- REVENUE CHART BY currency --}}
    <div class="mb-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                        <i class="fas fa-chart-line text-blue-800"></i>
                    </div>
                    <div>
                        <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Revenue Chart By Currency</h5>
                        <p class="text-sm font-normal text-gray-500">Monthly Revenue for {{ $year }}</p>
                    </div>
                </div>
            </div>

            <div id="revenue-chart-currency" class="text-gray-900"></div>

        </div>
    </div>

    <div class=" gap-4 mb-4 flex flex-col xl:flex-row">
        {{-- Order Count and Revenue --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 flex-1">
            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                        <i class="fas fa-chart-line text-blue-800"></i>
                    </div>
                    <div>
                        <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Order Count and Revenue</h5>
                        <p class="text-sm font-normal text-gray-500">Monthly Revenue for {{ $year }}</p>
                    </div>
                </div>
            </div>

            <div id="order-count-revenue" class="text-gray-900"></div>

        </div>

        {{-- Sales Share by Currency --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 flex-1">
            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                        <i class="fas fa-chart-pie text-blue-800"></i>
                    </div>
                    <div>
                        <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Sales Share by Currency</h5>
                        <p class="text-sm font-normal text-gray-500">Monthly Revenue for {{ $year }}</p>
                    </div>
                </div>
            </div>

            <div id="radial-chart" class="text-gray-900"></div>

        </div>
    </div>



    @push('scripts')
        <script src="{{ asset('js/apexcart.js') }}"></script>

        {{-- CUTSOMER PIE CHART --}}
        <script>
            const customerPercentages = @json($customerPercentage);

            const cutsomerPieOption = () => {
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

            if (document.getElementById("customer-pie-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("customer-pie-chart"), cutsomerPieOption());
                chart.render();
            }
        </script>

        {{-- REVENUE CHART --}}
        <script>
            const revenueChartOption = {
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
                    show: true,
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
                const chart = new ApexCharts(document.getElementById("revenue-chart"), revenueChartOption);
                chart.render();
            }
        </script>

        {{-- REVENUE CHART BY currency --}}
        <script>
            const revenueChartCurrencyOption = () => {
                return {
                    series: [{
                            name: 'Investment A',
                            type: 'column',
                            data: [25000, 39000, 65000, 45000, 79000, 80000, 69000, 63000, 60000, 66000, 90000, 78000]
                        },
                        {
                            name: 'Investment B',
                            type: 'column',
                            data: [22000, 37000, 60000, 43000, 75000, 77000, 67000, 61000, 58000, 64000, 88000, 75000]
                        },
                        {
                            name: 'Investment C',
                            type: 'column',
                            data: [20000, 34000, 58000, 40000, 70000, 73000, 64000, 59000, 55000, 61000, 85000, 72000]
                        },
                        {
                            name: 'Average Growth',
                            type: 'line',
                            data: [22333, 36667, 61000, 42667, 74667, 76667, 66667, 61000, 57667, 63667, 87667, 75000]
                        }
                    ],
                    chart: {
                        height: 400,
                        type: 'line',
                        stacked: false,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ["#1C64F2", "#16BDCA", "#F43F5E", "#FDBA8C"], // Biru, hijau, pink, oranye
                    stroke: {
                        width: [0, 0, 0, 3],
                        curve: 'smooth'
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '40%',
                            borderRadius: 5,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: ['Cook', 'Erin', 'Jack', 'Will', 'Gayle', 'Megan', 'John', 'Luke', 'Ellis', 'Mason',
                            'Elvis', 'Liam'
                        ],
                        labels: {
                            style: {
                                colors: '#6B7280',
                                fontSize: '12px',
                                fontWeight: 400
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#6B7280',
                                fontSize: '12px',
                                fontWeight: 400
                            },
                            formatter: value => (value >= 1000 ? `${value / 1000}k` : value)
                        },
                        title: {
                            text: "Amount ($)",
                            style: {
                                color: '#6B7280',
                                fontWeight: 500
                            }
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: value => `$${value >= 1000 ? `${value / 1000}k` : value}`
                        }
                    },
                    legend: {
                        position: 'bottom',
                        fontFamily: 'Inter, sans-serif'
                    },
                    responsive: [{
                        breakpoint: 640,
                        options: {
                            plotOptions: {
                                bar: {
                                    columnWidth: '20%'
                                }
                            },
                            chart: {
                                height: 320
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '10px'
                                    },
                                    formatter: title => title.slice(0, 3)
                                }
                            }
                        }
                    }]
                }
            }

            if (document.getElementById("revenue-chart-currency") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("revenue-chart-currency"), revenueChartCurrencyOption());
                chart.render();
            }
        </script>

        {{-- Order Count and Revenue --}}
        <script>
            const orderCountRevenueOption = () => {
                return {
                    series: [{
                            name: 'Revenue',
                            type: 'column',
                            data: [25000, 39000, 65000]
                        },
                        {
                            name: 'Order',
                            type: 'column',
                            data: [22000, 37000, 60000,]
                        },
                    ],
                    chart: {
                        height: 400,
                        type: 'line',
                        stacked: false,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ["#1C64F2", "#16BDCA"], // Biru, hijau, pink, oranye
                    stroke: {
                        width: [0, 0, 0, 3],
                        curve: 'smooth'
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '40%',
                            borderRadius: 5,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: ['IDR', 'USD', 'EUR'],
                        labels: {
                            style: {
                                colors: '#6B7280',
                                fontSize: '12px',
                                fontWeight: 400
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#6B7280',
                                fontSize: '12px',
                                fontWeight: 400
                            },
                            formatter: value => (value >= 1000 ? `${value / 1000}` : value)
                        },
                        title: {
                            text: "Amount",
                            style: {
                                color: '#6B7280',
                                fontWeight: 500
                            }
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: value => `$${value >= 1000 ? `${value / 1000}k` : value}`
                        }
                    },
                    legend: {
                        position: 'bottom',
                        fontFamily: 'Inter, sans-serif'
                    },
                    responsive: [{
                        breakpoint: 640,
                        options: {
                            plotOptions: {
                                bar: {
                                    columnWidth: '20%'
                                }
                            },
                            chart: {
                                height: 320
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '10px'
                                    },
                                    formatter: title => title.slice(0, 3)
                                }
                            }
                        }
                    }]
                }
            }

            if (document.getElementById("order-count-revenue") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("order-count-revenue"), orderCountRevenueOption());
                chart.render();
            }
        </script>

        {{-- Sales Share by Currency --}}
        <script>
            const getRadialChartOptions = () => {
                return {
                    chart: {
                        height: 400,
                        type: 'radialBar',
                    },
                    colors: ['#EF4444', '#8B5CF6', '#F59E0B'], // Tailwind colors: red-500, violet-500, yellow-500
                    series: [80, 50, 35],
                    labels: ['Comments', 'Replies', 'Shares'],
                    plotOptions: {
                        radialBar: {
                            size: 185,
                            hollow: {
                                size: '40%',
                            },
                            track: {
                                margin: 10,
                                background: '#F3F4F6', // Tailwind: base-200
                            },
                            dataLabels: {
                                name: {
                                    fontSize: '1.5rem',
                                    fontFamily: 'Inter, sans-serif',
                                },
                                value: {
                                    fontSize: '1rem',
                                    fontFamily: 'Inter, sans-serif',
                                    color: '#374151', // Tailwind: base-content (gray-700)
                                },
                                total: {
                                    show: true,
                                    fontWeight: 400,
                                    fontSize: '1.3rem',
                                    label: 'Total',
                                    color: '#374151',
                                    formatter: function(w) {
                                        return '69%';
                                    }
                                }
                            }
                        }
                    },
                    grid: {
                        padding: {
                            top: 0,
                            bottom: 0
                        },
                        borderColor: 'rgba(55, 65, 81, 0.4)', // Tailwind gray-700 @ 40%
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        labels: {
                            useSeriesColors: true,
                            colors: '#374151',
                            fontFamily: 'Inter, sans-serif'
                        }
                    },
                    stroke: {
                        lineCap: 'round',
                    },
                };
            };

            if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("radial-chart"), getRadialChartOptions());
                chart.render();
            }
        </script>
    @endpush
</x-layout>
