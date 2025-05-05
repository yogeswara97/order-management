@props([
    'year',
    'salesShare' => [],
])

<div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 flex-1 h-full">
    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
        <div class="flex items-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                <i class="fas fa-chart-pie text-blue-800"></i>
            </div>
            <div>
                <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Sales Share</h5>
                <p class="text-sm font-normal text-gray-500">Sales Share for {{ $year }}</p>
            </div>
        </div>
    </div>

    <div id="radial-chart" class="text-gray-900"></div>

</div>

@once
    @push('scripts')
        {{-- Sales Share by Currency --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const getRadialChartOptions = () => {
                    return {
                        chart: {
                            height: 400,
                            type: 'radialBar',
                        },
                        colors: ['#EF4444', '#8B5CF6', '#F59E0B'],

                        // data
                        series: @json($salesShare['series'] ?? [0, 0, 0]),
                        labels: @json($salesShare['labels'] ?? ['IDR', 'USD', 'EUR']),

                        plotOptions: {
                            radialBar: {
                                size: 185,
                                hollow: {
                                    size: '40%',
                                },
                                track: {
                                    margin: 10,
                                    background: '#F3F4F6',
                                },
                                dataLabels: {
                                    name: {
                                        fontSize: '1.5rem',
                                        fontFamily: 'Inter, sans-serif',
                                    },
                                    value: {
                                        fontSize: '1rem',
                                        fontFamily: 'Inter, sans-serif',
                                        color: '#374151',
                                    },
                                    total: {
                                        show: true,
                                        fontWeight: 400,
                                        fontSize: '1.3rem',
                                        label: 'Sales',
                                        color: '#374151',
                                        formatter: function(w) {
                                            const total = w.globals.series.reduce((sum, value) => sum + value, 0);
                                            return total.toFixed(2) + '%';
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
                            borderColor: 'rgba(55, 65, 81, 0.4)',
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
            })
        </script>
    @endpush
@endonce
