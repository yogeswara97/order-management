<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- METRICS --}}
    <section>
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
            <x-dashboard.metric-card icon="fas fa-inbox" title="New Order" :value="$newOrderCount" />

            <x-dashboard.metric-card icon="fa fa-file-invoice" title="Revenue Month" :value="format_currency($revenueCurrentMonth, 'IDR', 'id_ID')" :percentage="$percentageMonth['percentage']"
                :percentageStatus="$percentageMonth['status']" />

            <x-dashboard.metric-card icon="fa fa-file-invoice" title="Revenue Year" :value="format_currency($revenueCurrentYear, 'IDR', 'id_ID')" :percentage="$percentageYear['percentage']"
                :percentageStatus="$percentageMonth['status']" />

            <x-dashboard.metric-card icon="fas fa-users" title="Total Customers" :value="$totalCustomers" />

        </div>
    </section>

    {{-- LATEST ORDER AND CUSTOMER PIE --}}
    <section>
        <div class=" gap-4 mb-4 flex flex-col xl:flex-row">
            {{-- LATEST ORDER TABLE --}}
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
                                    class="button-mini-show">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('order.edit', $order->id) }}"
                                    class="button-mini-edit">
                                    <i class="fas fa-pencil"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </x-table>
            </div>

            {{-- CUTSOMER PIE CHART --}}
            <x-charts.customer-pie :percentages="$customerPercentage" />

        </div>
    </section>

    {{-- REVENUE CHART --}}
    <section>
        <div class="mb-4">
            <x-charts.revenue-chart :year="$year" :monthlyRevenue="$monthlyRevenue" />
        </div>
    </section>

    {{-- REVENUE CHART BY currency --}}
    <section>
        <div class="mb-4">
            <x-charts.revenue-chart-currency :year="$year" :monthlyRevenueCurrency="$monthlyRevenueCurrency"/>
        </div>
    </section>

    {{-- Order Count and Revenue and Sales Share --}}
    <section>
        <div class="gap-4 mb-4 flex flex-col xl:flex-row">
            {{-- Order Count and Revenue --}}
            <x-charts.order-count-revenue :year="$year" :orderCountRevenue="$orderCountRevenue"/>

            {{-- Sales Share by Currency --}}
            <div class="w-1/3">
                <x-charts.sales-share :year="$year" :salesShare="$salesShare"/>
            </div>
        </div>
    </section>

    {{-- TOP CUTSOMERS BY REVENUE AND ORDER --}}
    <section>
        <div class="gap-4 mb-4 flex flex-col xl:flex-row">
            {{-- TOP CUTSOMERS BY REVENUE AND ORDER --}}
            <x-charts.top-customer-revenue :topCustomersChart="$topCustomersRevenue"/>
            {{-- TOP CUTSOMERS BY REVENUE AND ORDER --}}
            <x-charts.top-customer-order :topCustomersOrder="$topCustomersOrder"/>
        </div>
    </section>



    @push('scripts')
        <script src="{{ asset('js/apexcart.js') }}"></script>
    @endpush
</x-layout>
