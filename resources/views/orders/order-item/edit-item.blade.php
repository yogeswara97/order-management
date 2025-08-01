<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- HEADER --}}
    <x-header title="Detail Order / Edit Item" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Orders', 'url' => route('order.index')],
        ['label' => 'Detail Order', 'url' => route('order.show', $orderId)],
        ['label' => 'Edit Item', 'url' => route('editItem', ['orderId' => $orderId, 'itemId' => $item->id])],
    ]" />

    <x-alret />

    {{-- FORM --}}
    <form action="{{ route('updateItem', ['orderId' => $orderId, 'itemId' => $item->id]) }}" method="POST"
        enctype="multipart/form-data" class="wrapper">

        @csrf
        @method('PUT')
        <div class="flex items-center justify-center w-full mb-4">
            <label for="dropzone-file"
                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                <div id="preview-element"
                    class="{{ $item->image == null ? '' : 'hidden' }} flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                            upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                </div>
                <img id="preview" src="{{ url('storage/' . $item->image) }}" alt="Image Preview"
                    class="{{ $item->image == null ? 'hidden' : '' }} max-w-full max-h-full object-cover my-2" />
                <input id="dropzone-file" type="file" class="hidden" name="image" accept="image/*" />
            </label>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-4">
            <div>
                <label for="item_name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                <input type="text" id="item_name" name="item_name" value="{{ $item->item_name }}" class="input"
                    placeholder="Item Name">
            </div>

            <div>
                <label for="code" class="block mb-2 text-sm font-medium text-gray-900">Code</label>
                <input type="text" id="code" name="code" value="{{ $item->code }}" class="input"
                    placeholder="Code">
            </div>

            <div>
                <label for="color" class="block mb-2 text-sm font-medium text-gray-900">Color</label>
                <input type="text" id="color" name="color" value="{{ $item->color }}" class="input"
                    placeholder="Color">
            </div>

            <div>
                <label for="unit" class="block mb-2 text-sm font-medium text-gray-900">Unit</label>
                <input type="text" id="unit" name="unit" value="{{ $item->unit }}" class="input"
                    placeholder="Unit">
            </div>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-3">

            <div>
                <label for="unit_price" class="block mb-2 text-sm font-medium text-gray-900">Unit Price</label>
                <input type="number" id="unit_price" name="unit_price" value="{{ $item->unit_price }}" class="input"
                    placeholder="Unit Price">
            </div>

            <div>
                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="{{ $item->quantity }}" class="input"
                    placeholder="Quantity">
            </div>

            <div>
                <label for="total_price" class="block mb-2 text-sm font-medium text-gray-900">Total Price</label>
                <input type="text" id="total_price" value="{{ $item->total_price }}" class="input"
                    placeholder="Total Price" readonly>
            </div>
            <input type="hidden" id="total_price_hidden" name="total_price" value="{{ $item->total_price }}"
                class="text-black border-black">

        </div>

        <div class="grid gap-6 mb-6 md:grid-cols-4">
            <div>
                <label for="format" class="block mb-2 text-sm font-medium text-gray-900">Format</label>
                <select id="format" name="format" class="select">
                    <option value="mm" {{ $item->format == 'mm' ? 'selected' : '' }}>Milimeters</option>
                    <option value="cm" {{ $item->format == 'cm' ? 'selected' : '' }}>Centimeters </option>
                </select>
            </div>
            <div>
                <label for="size_w" class="block mb-2 text-sm font-medium text-gray-900">Width (W)</label>
                <input type="text" id="size_w" name="size_w" value="{{ $item->size_w }}" class="input"
                    placeholder="Width">
            </div>

            <div>
                <label for="size_d" class="block mb-2 text-sm font-medium text-gray-900">Depth (D)</label>
                <input type="text" id="size_d" name="size_d" value="{{ $item->size_d }}" class="input"
                    placeholder="Depth">
            </div>

            <div>
                <label for="size_h" class="block mb-2 text-sm font-medium text-gray-900">Height (H)</label>
                <input type="text" id="size_h" name="size_h" value="{{ $item->size_h }}" class="input"
                    placeholder="Height">
            </div>
        </div>

        <div class="mb-6">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
            <textarea id="description" name="description" rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Write product description here">{{ $item->description }}</textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('order.show', $orderId) }}" class="button-back">
                Back to Order
            </a>
            <button type="submit" class="button-submit">
                Submit
            </button>
        </div>
    </form>

    @push('scripts')
        <script>
            const unitPrice = document.getElementById('unit_price');
            const qty = document.getElementById('quantity');
            const total_price = document.getElementById('total_price');
            const total_price_hidden = document.getElementById('total_price_hidden');
            const imageInput = document.getElementById('dropzone-file');
            const previewElement = document.getElementById('preview-element');
            const preview = document.getElementById('preview');
            const currency = "{{ $currency }}";

            function calculateTotalPrice() {
                const price = parseFloat(unitPrice.value.replace(/\./g, '').replace(/[^0-9]/g, '')) ||
                    0; // Menghapus titik dan simbol mata uang sebelum parsing
                const quantity = parseInt(qty.value) || 0;
                const total = price * quantity;

                // Format the total price based on the selected currency
                if (currency === 'usd') {
                    total_price.value = formatUSD(total);
                    total_price_hidden.value = total
                } else if (currency === 'eur') {
                    total_price.value = formatEUR(total);
                    total_price_hidden.value = total
                } else if (currency === 'idr') {
                    total_price.value = formatIDR(total);
                    total_price_hidden.value = total
                }
            }

            function formatUSD(amount) {
                return amount.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD'
                });
            }

            function formatEUR(amount) {
                return amount.toLocaleString('de-DE', {
                    style: 'currency',
                    currency: 'EUR'
                });
            }

            function formatIDR(amount) {
                return amount.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            }

            // Call calculateTotalPrice on page load
            document.addEventListener('DOMContentLoaded', function() {
                calculateTotalPrice();
            });

            unitPrice.addEventListener('input', calculateTotalPrice);
            qty.addEventListener('input', calculateTotalPrice);

            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                        previewElement.classList.add('hidden');
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.classList.add('hidden');
                    previewElement.classList.remove('hidden');
                }
            });
        </script>
    @endpush

</x-layout>
