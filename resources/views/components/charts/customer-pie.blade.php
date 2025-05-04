@props([
    'percentages' => ['member' => 0, 'common' => 0],
])

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

@once
    @push('scripts')
        {{-- CUTSOMER PIE CHART --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const customerPercentages = @json($percentages);

                const cutsomerPieOption = () => {
                    return {
                        series: [parseFloat(customerPercentages['member']), parseFloat(customerPercentages[
                            'common'])],
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
            })
        </script>
    @endpush
@endonce
