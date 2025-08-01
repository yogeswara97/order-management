<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret></x-alret>

    <x-header title="Orders" :breadcrumbs="[['label' => 'Home', 'url' => route('index')], ['label' => 'Orders', 'url' => route('order.index')]]" />

    {{-- METRICS --}}
    <section>
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4 mb-4">
            <x-dashboard.metric-card icon="fas fa-inbox" title="New" :value="$statusCounts['new'] ?? 0" />
            <x-dashboard.metric-card icon="fas fa-inbox" title="Quotation" :value="$statusCounts['quotation'] ?? 0" />
            <x-dashboard.metric-card icon="fas fa-inbox" title="Invoice" :value="$statusCounts['invoice'] ?? 0" />
            <x-dashboard.metric-card icon="fas fa-inbox" title="Paid" :value="$statusCounts['paid'] ?? 0" />
            <x-dashboard.metric-card icon="fas fa-inbox" title="Cancelled" :value="$statusCounts['cancelled'] ?? 0" />
        </div>
    </section>

    <div class="overflow-x-auto rounded-2xl border border-gray-200">

        {{-- TABLE HEAD --}}
        <x-table-header :dataset="$customersName" :create="'Create Order'" :routeReset="route('order.index')" :routeCreate="route('order.create')">
            <div class="flex items-center">
                <div class="relative">
                    <input id="datepicker-range-start" name="start" type="date" class="input"
                        placeholder="Select date start" value="{{ request()->input('start') }}">
                </div>
                <span class="mx-4 text-gray-500">to</span>
                <div class="relative">
                    <input id="datepicker-range-end" name="end" type="date" class="input"
                        placeholder="Select date end" value="{{ request()->input('end') }}">
                </div>
            </div>
            <div class="w-full sm:w-28">
                <select id="status" name="status" class="select w-full">
                    <option value="">All Status</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                    <option value="quotation" {{ request('status') === 'quotation' ? 'selected' : '' }}>Quotation
                    </option>
                    <option value="invoice" {{ request('status') === 'invoice' ? 'selected' : '' }}>Invoice</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>
        </x-table-header>

        {{-- tABLE --}}
        <x-table :headers="['Order no', 'Customer Name', 'Date', 'Status', 'Total', 'Action']">
            @foreach ($orders as $order)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $order->order_number }}
                    </td>
                    <td
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  {{ $order->customer->name ?? 'text-red-600' }} ">
                        {{ $order->customer->name ?? 'No customer' }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $order->order_date }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <span
                            class=" flex items-center justify-center p-2 rounded-md capitalize
                                @if ($order->status == 'new') bg-blue-400 text-blue-950 bg-opacity-60
                                @elseif ($order->status == 'quotation')
                                    bg-slate-400 text-slate-950 bg-opacity-60
                                @elseif ($order->status == 'invoice')
                                    bg-yellow-400 text-yellow-950 bg-opacity-60
                                @elseif ($order->status == 'paid')
                                    bg-green-400 text-green-950 bg-opacity-60
                                @elseif ($order->status == 'cancelled')
                                    bg-red-400 text-red-950 bg-opacity-60 @endif
                            ">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ format_currency($order->grand_total, $order->currency, 'id_ID') }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex items-center gap-2">
                        <a href="{{ route('order.show', $order->id) }}" class="button-mini-show">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('order.edit', $order->id) }}" class="button-mini-edit">
                            <i class="fas fa-pencil"></i>
                        </a>
                    </td>

                </tr>
            @endforeach
        </x-table>

        {{-- TABLE NAV --}}
        <x-table-navigation :dataset="$orders" :perPage="$perPage" />


    </div>
</x-layout>
