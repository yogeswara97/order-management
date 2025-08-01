@props([
    'topCustomersChart' => [],
])


<div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 flex-1">
    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
        <div class="flex items-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                <i class="fas fa-chart-bar text-blue-800"></i>
            </div>
            <div>
                <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Top Customers by Revenue (IDR)</h5>
                <p class="text-sm font-normal text-gray-500">Top Customers by Revenue</p>
            </div>
        </div>
    </div>

    <div id="top-customers-chart" class="text-gray-900"></div>

</div>

@once
    @push('scripts')
        {{-- TOP CUTSOMERS BY REVENUE --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const data = @json($topCustomersChart);

                const topCustomersOption = {
                    chart: {
                        type: "bar",
                        height: 400,
                        fontFamily: "Inter, sans-serif",
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    // for data
                    series: [{
                        name: "Total Order",
                        data: data.data
                    }, ],
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            columnWidth: "16px",
                            borderRadius: 4,
                            borderRadiusApplication: "end"
                        }
                    },
                    colors: ["#16BDCA"], // Accent & warning vibes
                    legend: {
                        show: true,
                        position: "top",
                        markers: {
                            shape: "circle"
                        },
                        labels: {
                            colors: "#6B7280", // Tailwind gray-500
                            useSeriesColors: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        // for customer name
                        categories: data.categories,
                        labels: {
                            style: {
                                colors: "#6B7280",
                                fontSize: "12px",
                                fontWeight: 400
                            },
                            formatter: (value) => {
                                if (value >= 1000) {
                                    return new Intl.NumberFormat('id-ID').format(value / 1000) + 'k';
                                }
                                return new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            align: "left",
                            minWidth: 0,
                            maxWidth: 120,
                            style: {
                                colors: "#6B7280",
                                fontSize: "12px",
                                fontWeight: 400
                            },
                            formatter: title => title
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: "darken",
                                value: 0.9
                            }
                        }
                    }
                };

                if (document.getElementById("top-customers-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("top-customers-chart"), topCustomersOption);
                    chart.render();
                }
            })
        </script>
    @endpush
@endonce
