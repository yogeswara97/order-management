<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- HEADER --}}
    <x-header title="Detail Customer" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Customer', 'url' => route('customer.index')],
        ['label' => 'Detail Customer', 'url' => route('customer.show',$customer->id)],
    ]" />

    {{-- FORM --}}
    <form class="bg-gray-50 wrapper mb-6">

        {{-- CUSTOMER --}}
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Customer Name <span
                        class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" readonly value="{{ $customer->name }}"
                    class="input"
                    placeholder="John Doe">
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Customer Email</label>
                <input type="email" id="email" name="email" readonly value="{{ $customer->email }}"
                    class="input"
                    placeholder="example@example.com">
            </div>

        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-3">

            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Customer Phone</label>
                <input type="text" id="phone" name="phone" readonly value="{{ $customer->phone }}"
                    class="input"
                    placeholder="123-456-7890">
            </div>

            <div>
                <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Customer
                    Country</label>
                <input type="text" id="country" name="country" readonly value="{{ $customer->country }}"
                    class="input"
                    placeholder="Country">
            </div>

            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Customer
                    Status</label>
                <input type="text" id="status" name="status" readonly value="{{ $customer->status }}"
                    class="input"
                    placeholder="Status">
            </div>
        </div>

    </form>
    <div class="overflow-x-auto rounded-2xl border border-gray-200">
        <div class="flex justify-between p-4 mb-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 me-3">
                    <i class="fas fa-inbox text-blue-800"></i>
                </div>
                <div>
                    <h5 class="leading-none text-2xl font-bold text-gray-900 pb-1">Customer order</h5>
                </div>
            </div>
        </div>

        <x-table :headers="['Invoice no','Customer Name','Date','Status','Total','Action']">
            @foreach ($orders as $order)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $order->status == 'quotation' ? 'Quo' : ($order->status == 'invoice' ? 'Inv' : ($order->status == 'new' ? 'New' : 'New')) }}
                            -{{ $order->id }}
                            -{{ \Carbon\Carbon::parse($order->order_date)->format('Y') }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  {{ $order->customer->name ?? 'text-red-600' }} ">
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
        <x-table-navigation :dataset="$orders" :perPage="$perPage"/>
    </div>

</x-layout>
