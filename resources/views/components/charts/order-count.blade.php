@props([
    'year',
    'orderCountRevenue' => [],
])

<div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 flex-1">
    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
        <div class="flex items-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                <i class="fas fa-chart-line text-blue-800"></i>
            </div>
            <div>
                <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Order Count</h5>
                <p class="text-sm font-normal text-gray-500">Order Count for {{ $year }}</p>
            </div>
        </div>
    </div>

    <div id="order-count" class="text-gray-900"></div>

</div>


@once
    @push('scripts')
        {{-- Order Count and Revenue --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const orderCountOption = () => {
                    const data = @json($orderCountRevenue);
                    console.log(data);

                    return {
                        series: [
                            {
                                name: 'Order',
                                type: 'column',
                                data: data.order_count
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
                        colors: ["#16BDCA"], // Biru, hijau, pink, oranye
                        stroke: {
                            width: [0, 0, 0, 3],
                            curve: 'smooth'
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '80%',
                                borderRadius: 5,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: data.currency,
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
                                formatter: value => `${value >= 1000 ? `${value / 1000}k` : value}`
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

                if (document.getElementById("order-count") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("order-count"),
                        orderCountOption());
                    chart.render();
                }
            })
        </script>
    @endpush
@endonce
