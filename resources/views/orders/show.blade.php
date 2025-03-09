<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret></x-alret>

    {{-- HEADER --}}
    <x-header title="Orders" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Orders', 'url' => route('order.index')],
        ['label' => 'Detail Orders', 'url' => route('order.show',$order->id)],
    ]" >
        #{{ $order->status == 'quotation' ? 'Quo' : ($order->status == 'invoice' ? 'Inv' : ($order->status == 'new' ? 'New' : 'New')) }}
        -{{ $order->id }}
        -{{ \Carbon\Carbon::parse($order->order_date)->format('Y') }}
    </x-header>

    {{-- FORM --}}
    <form>
        <div class="wrapper mb-8">

            {{-- CUSTOMER --}}
            <h2 class="text-gray-900 font-semibold text-xl py-4 flex justify-between items-end">
                Customer
                @if ($order->status !== 'new')

                <div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('exportPdf', $order->id) }}"
                            class="button-delete">
                            <i class="fas fa-file-pdf"></i>
                            Export to PDF
                        </a>
                    </div>
                </div>
                @endif
            </h2>
            <hr class="mb-4">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Customer Name</label>
                    <input type="text" readonly class="input" value="{{ $order->customer->name ?? '' }}">
                </div>


                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Customer Email</label>
                    <input type="email" readonly class="input" value="{{ $order->customer->email ?? '' }}">
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Customer Phone</label>
                    <input type="tel" readonly class="input" value="{{ $order->customer->phone ?? '' }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Customer Country</label>
                    <input type="text" readonly class="input" value="{{ $order->customer->country ?? '' }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Customer Status</label>
                    <input type="text" readonly class="input" value="{{ $order->customer->status ?? '' }}">
                </div>
            </div>

            {{-- ORDER --}}
            <h2 class="text-gray-900 font-semibold text-xl py-4">Order Data</h2>
            <hr class="mb-4">
            <div class="grid gap-6 mb-6 md:grid-cols-4">

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Order Date</label>
                    <input type="text" readonly class="input" value="{{ $order->order_date }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Reference Number</label>
                    <input type="text" readonly class="input" value="{{ $order->reference_number }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Order Number</label>
                    <input type="text" readonly class="input" value="{{ $order->order_number }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Object</label>
                    <input type="text" readonly class="input" value="{{ $order->object }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Cargo</label>
                    <input type="text" readonly class="input" value="{{ $order->cargo }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                    <input type="text" readonly class="input" value="{{ ucfirst($order->status) }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Currency</label>
                    <input type="text" readonly class="input uppercase" value="{{ $order->currency }}">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Exchange rate to IDR</label>
                    <input type="text" readonly id="exchange" class="input"
                        value="{{ format_currency($order->exchange_rate, 'IDR', 'id_ID') }}">
                </div>

            </div>

            {{-- DEPOSIT --}}
            <h2 class="text-gray-900 font-semibold text-xl py-4">Deposit</h2>
            <hr class="mb-4">
            <div class="grid gap-6 mb-6 md:grid-cols-4">

                <div class="md:col-span-1">
                    <label for="deposit_amount" class="block mb-2 text-sm font-medium text-gray-900">
                        Deposit Amount <span class="uppercase">({{ $order->currency }})</span>
                    </label>
                    <input type="text" id="deposit_amount" readonly
                        value="{{ format_currency($order->deposit_amount, $order->currency, 'id_ID') }}" class="input"
                        placeholder="Deposit Amount">
                </div>

                <div class="md:col-span-3">
                    <label for="deposit_description" class="block mb-2 text-sm font-medium text-gray-900">Deposit
                        Description</label>
                    <input type="text" readonly value="{{ $order->deposit_description }}" class="input"
                        placeholder="Deposit Description">
                </div>

            </div>

            {{-- Terms and conditions  --}}
            <h2 class="text-gray-900 font-semibold text-xl py-4">Terms and Conditions</h2>
            <hr class="mb-4">
            <div class="mb-6">
                <textarea id="terms_conditions" name="terms_conditions" rows="4" class="input h-60"
                    placeholder="Write product description here" readonly>{{ $order->terms_conditions }}
                </textarea>
            </div>

            {{-- TOTAL, VAT, GRAND TOTAL --}}
            <h2 class="text-gray-900 font-semibold text-xl py-4">Total</h2>
            <hr class="mb-4">
            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <div>
                    <label for="total" class="block mb-2 text-sm font-medium text-gray-900">
                        Total <span class="uppercase">({{ $order->currency }})</span>
                    </label>
                    <input type="text" id="total"
                        value="{{ format_currency($order->total, $order->currency, 'id_ID') }}" class="input"
                        placeholder="Total" readonly>
                </div>

                <div>
                    <label for="vat" class="block mb-2 text-sm font-medium text-gray-900">VAT
                        ({{ $order->vat }}%)</label>
                    <input type="text" id="vat"
                        value="{{ format_currency($order->vat_total, $order->currency, 'id_ID') }}" class="input"
                        placeholder="VAT" readonly>
                </div>

                <div>
                    <label for="grand_total" class="block mb-2 text-sm font-medium text-gray-900">
                        Grand Total <span class="uppercase">({{ $order->currency }})</span>
                    </label>
                    <input type="text" id="grand_total"
                        value="{{ format_currency($order->grand_total, $order->currency, 'id_ID') }}" class="input"
                        placeholder="Grand Total" readonly>
                </div>
            </div>

        </div>
    </form>




    {{-- TABLE --}}
    <div class="flex items-center justify-end space-y-3 md:space-y-0 md:space-x-4 p-4">
            <a href="{{ route('createItem', $order->id) }}"
                class="button-add">
                Create New Item
            </a>
    </div>
    <div class="overflow-x-auto rounded-2xl border border-gray-200">

        <x-table :headers="['No', 'Image', 'Item Name', 'Qty', 'Unit', 'Unit Price', 'Total Price', 'Action']">
            @foreach ($order->orderItems as $items)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 text-gray-800 font-semibold">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <img src="{{ url('storage/' . $items->image) }}" alt=" " title=""
                            style="max-width: 200px; max-height: 200px;;" />
                    </td>
                    <td class="px-6 py-4">
                        {{ $items->item_name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $items->quantity }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $items->unit }}
                    </td>
                    <td class="px-6 py-4">
                        {{ format_currency($items->unit_price, $order->currency, 'id_ID') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ format_currency($items->total_price, $order->currency, 'id_ID') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-1 gap-2">
                            <a href="{{ route('editItem', ['orderId' => $order->id, 'itemId' => $items->id]) }}"
                                class="button-mini-edit">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <form
                                action="{{ route('destroyItem', ['orderId' => $order->id, 'itemId' => $items->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                    class="button-mini-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            @endforeach
        </x-table>
    </div>



    @push('scripts')
        <script src="{{ asset('quill/quill.js') }}"></script>
        <script>
            const quill = new Quill('#editor', {
                theme: 'bubble'
            });

            quill.root.style.color = '#111';
        </script>
    @endpush

</x-layout>
