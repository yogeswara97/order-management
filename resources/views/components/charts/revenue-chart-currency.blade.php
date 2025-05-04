@props(['year', 'monthlyRevenueCurrency' => ['idr', 'usd', 'eur']])

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

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const revenueData = @json($monthlyRevenueCurrency);
                const numberFormatter = new Intl.NumberFormat('en-US');

                const revenueChartCurrencyOption = () => {
                    return {
                        series: [{
                                name: 'IDR',
                                type: 'column',
                                data: revenueData.idr.map(item => item.y)
                            },
                            {
                                name: 'USD',
                                type: 'column',
                                data: revenueData.usd.map(item => item.y)
                            },
                            {
                                name: 'EUR',
                                type: 'column',
                                data: revenueData.eur.map(item => item.y)
                            },
                            {
                                name: 'Average Growth',
                                type: 'line',
                                data: revenueData.avg_growth.map(item => item.y)
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
                        colors: ["#F43F5E", "#1C64F2", "#16BDCA", "#FDBA8C"], // Biru, hijau, pink, oranye
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
                            categories: revenueData.idr.map(item => item.x),
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
                                formatter: value => numberFormatter.format(value)
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
                    const chart = new ApexCharts(document.getElementById("revenue-chart-currency"),
                        revenueChartCurrencyOption());
                    chart.render();
                }
            })
        </script>
    @endpush
@endonce
