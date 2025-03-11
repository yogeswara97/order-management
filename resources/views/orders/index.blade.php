<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>


    <x-alret></x-alret>

    <x-header title="Orders" :breadcrumbs="[['label' => 'Home', 'url' => route('index')], ['label' => 'Orders', 'url' => route('order.index')]]" />

    <div class="overflow-x-auto rounded-2xl border border-gray-200">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">

            <form action="{{ route('order.index') }}" method="GET" class="flex items-center" id="date-range-picker">
                <div class="relative">
                    <input id="datepicker-range-start" name="start" type="date" class="input"
                        placeholder="Select date start" value="{{ request()->input('start') }}">
                </div>
                <span class="mx-4 text-gray-500">to</span>
                <div class="relative">
                    <input id="datepicker-range-end" name="end" type="date" class="input"
                        placeholder="Select date end" value="{{ request()->input('end') }}">
                </div>

                <button type="submit" class="button-submit ml-4">
                    Filter
                </button>
            </form>
            <div
                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                <a href="{{ route('order.index') }}" class="button-delete">
                    Reset Filter
                </a>
                <a href="{{ route('order.create') }}" class="button-add">
                    Create Order
                </a>
            </div>
        </div>
        <x-table :headers="['Invoice no', 'Customer Name', 'Date', 'Status', 'Total', 'Action']">
            @foreach ($orders as $order)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $order->status == 'quotation' ? 'Quo' : ($order->status == 'invoice' ? 'Inv' : ($order->status == 'new' ? 'New' : 'New')) }}
                        - {{ $order->id }}
                        - {{ \Carbon\Carbon::parse($order->order_date)->format('Y') }}
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
        <x-table-navigation :dataset="$orders" :perPage="$perPage" />


    </div>
</x-layout>
