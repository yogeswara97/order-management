<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- METRICS --}}
    <section>
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
            <x-dashboard.metric-card icon="fas fa-inbox" title="New Order" :value="$newOrderCount" />

            <x-dashboard.metric-card icon="fas fa-inbox" title="Total Order" :value="$totalOrder" />

            <x-dashboard.metric-card icon="fa fa-file-invoice" title="Revenue Year" :value="format_currency($revenueCurrentYear['revenue'], 'IDR', 'id_ID')" :percentage="$revenueCurrentYear['percentage']"
                :percentageStatus="$revenueCurrentYear['status']" />

            <x-dashboard.metric-card icon="fas fa-users" title="Total Customers" :value="$totalCustomers" />

        </div>
    </section>

    {{-- LATEST ORDER AND CUSTOMER PIE --}}
    <section>
        <div class=" gap-4 mb-4 flex flex-col xl:flex-row">
            {{-- LATEST ORDER TABLE --}}
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
                <div class="overflow-x-scroll">
                    <x-table :headers="['Customer Name', 'Status', 'Total', 'Action']">
                        @foreach ($latestOrders as $order)
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
            </div>

            {{-- CUTSOMER PIE CHART --}}
            <x-charts.customer-pie :percentages="$customerPercentage" />

        </div>
    </section>

    {{-- SELECT YEAR BUTTON --}}
    <section class="mb-4">
        <div class="inline-block rounded-2xl border border-gray-200 bg-white p-6 md:p-8 ">
            <div class="flex gap-4 w-auto">
                <div class="flex items-center">
                    <div>
                        <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Select Year</h5>
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
        <div class="gap-4 mb-4 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
            {{-- Order Count and Revenue (2-up on md) --}}
            <x-charts.order-revenue :year="$year" :orderCountRevenue="$orderCountRevenue"/>
            <x-charts.order-count :year="$year" :orderCountRevenue="$orderCountRevenue"/>

            {{-- Sales Share by Currency (full width below on md) --}}
            <div class="lg:col-span-2 xl:col-span-1">
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
