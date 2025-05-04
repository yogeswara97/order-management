@props([
    'year',
    'monthlyRevenue' => [],
])

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
            <a href="{{ route('index', ['year' => $year - 1]) }}" class="button-mini-show flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <span class="text-gray-900 font-bold text-lg">{{ $year }}</span>
            <a href="{{ route('index', ['year' => $year + 1]) }}" class="button-mini-show flex items-center gap-2">
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div id="revenue-chart" class="text-gray-900"></div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const revenueChartOption = {
                    colors: ["#1A56DB"],
                    series: [{
                        name: "Monthly Revenue",
                        data: @json($monthlyRevenue),
                    }],
                    chart: {
                        type: "bar",
                        height: "320px",
                        fontFamily: "Inter, sans-serif",
                        toolbar: { show: false },
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
                        style: { fontFamily: "Inter, sans-serif" },
                    },
                    states: {
                        hover: { filter: { type: "darken", value: 1 } },
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ["#1A56DB"],
                    },
                    grid: {
                        show: true,
                        strokeDashArray: 4,
                        padding: { left: 2, right: 2, top: -14 },
                    },
                    dataLabels: { enabled: false },
                    legend: { show: false },
                    xaxis: {
                        floating: false,
                        labels: {
                            show: true,
                            style: {
                                fontFamily: "Inter, sans-serif",
                                cssClass: 'text-xs font-normal text-gray-500'
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                    },
                    yaxis: {
                        show: true,
                        labels: {
                            show: true,
                            formatter: function (value) {
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
                    fill: { opacity: 1 },
                }

                if (document.getElementById("revenue-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("revenue-chart"), revenueChartOption);
                    chart.render();
                }
            });
        </script>
    @endpush
@endonce
