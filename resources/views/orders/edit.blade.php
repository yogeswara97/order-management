<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    <x-header title="Edit Orders" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Orders', 'url' => route('order.index')],
        ['label' => 'Edit Order', 'url' => route('order.edit', $order->id)],
    ]" />

    {{-- FORM --}}
    <form action="{{ route('order.update', $order->id) }}" method="POST" class="wrapper">
        @csrf
        @method('PUT')

        {{-- CUSTOMER --}}
        <div class="flex items-center justify-between">
            <h2 class="text-gray-900 font-semibold text-xl py-4">Customer</h2>
            <div class="flex gap-2">
                <button id="reset-customer" data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="button-delete"
                    type="button">
                    Reset Customer
                </button>
                <button id="modal-button" data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="button-add"
                    type="button">
                    Change From Customer List
                </button>
            </div>
        </div>
        <hr class="mb-4">
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            {{-- <label for="customer_id" class="block mb-2 text-sm font-medium text-gray-900">Customer Id</label> --}}
            <input type="hidden" id="customer_id" name="customer_id" value={{ $order->customer->id ?? '' }} readonly
                class="input"
                placeholder="Customer Id here">

            <div>
                <label for="customer_name" class="block mb-2 text-sm font-medium text-gray-900">Customer Name <span
                        class="text-red-500">*</span></label>
                <input type="text" id="customer_name" name="customer_name" value="{{ $order->customer->name ?? '' }}"
                    readonly
                    class="input"
                    placeholder="John Doe">
            </div>

            <div>
                <label for="customer_email" class="block mb-2 text-sm font-medium text-gray-900">Customer Email</label>
                <input type="email" id="customer_email" name="customer_email"
                    value="{{ $order->customer->email ?? '' }}" readonly
                    class="input"
                    placeholder="example@example.com">
            </div>

            <div>
                <label for="customer_phone" class="block mb-2 text-sm font-medium text-gray-900">Customer Phone</label>
                <input type="text" id="customer_phone" name="customer_phone"
                    value="{{ $order->customer->phone ?? '' }}" readonly
                    class="input"
                    placeholder="123-456-7890">
            </div>

            <div>
                <label for="customer_country" class="block mb-2 text-sm font-medium text-gray-900">Customer
                    Country</label>
                <input type="text" id="customer_country" name="customer_country"
                    value="{{ $order->customer->country ?? '' }}" readonly
                    class="input"
                    placeholder="Country">
            </div>
        </div>

        {{-- ORDER --}}
        <h2 class="text-gray-900 font-semibold text-xl py-4">Order Data</h2>
        <hr class="mb-4">
        <div class="grid gap-6 mb-6 md:grid-cols-4">

            <div>
                <label for="order_date" class="block mb-2 text-sm font-medium text-gray-900">Order Date</label>
                <input type="date" id="order_date" name="order_date" value="{{ $order->order_date }}"
                    class="input">

            </div>

            <div>
                <label for="reference_number" class="block mb-2 text-sm font-medium text-gray-900">Reference
                    Number</label>
                <input type="text" id="reference_number" name="reference_number"
                    value="{{ $order->reference_number }}"
                    class="input"
                    placeholder="Reference Number">
            </div>

            <div>
                <label for="order_number" class="block mb-2 text-sm font-medium text-gray-900">Order Number</label>
                <input type="text" id="order_number" name="order_number" value="{{ $order->order_number }}"
                    class="input"
                    placeholder="Order Number">
            </div>

            <div>
                <label for="object" class="block mb-2 text-sm font-medium text-gray-900">Object</label>
                <input type="text" id="object" name="object" value="{{ $order->object }}"
                    class="input"
                    placeholder="object">
            </div>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-5">

            <div>
                <label for="cargo" class="block mb-2 text-sm font-medium text-gray-900">Cargo</label>
                <input type="text" id="cargo" name="cargo" value="{{ $order->cargo }}"
                    class="input"
                    placeholder="Cargo">
            </div>

            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                <select id="status" name="status"
                    class="select">
                    <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>New</option>
                    <option value="quotation" {{ $order->status == 'quotation' ? 'selected' : '' }}>Quotation
                    </option>
                    <option value="invoice" {{ $order->status == 'invoice' ? 'selected' : '' }}>Invoice</option>
                </select>
            </div>

            <div>
                <label for="currency" class="block mb-2 text-sm font-medium text-gray-900">Currency</label>
                <select id="currency" name="currency" {{ $order_count != 0 ? 'disabled' : '' }}
                    class="select">
                    <option value="usd" {{ $order->currency == 'usd' ? 'selected' : '' }}>USD</option>
                    <option value="eur" {{ $order->currency == 'eur' ? 'selected' : '' }}>EUR</option>
                    <option value="idr" {{ $order->currency == 'idr' ? 'selected' : '' }}>IDR</option>
                </select>
            </div>

            <div>
                <label for="exchange" class="block mb-2 text-sm font-medium text-gray-900">Exchange rate to
                    IDR</label>
                <input type="number" id="exchange" name="exchange_rate" value="{{ $order->exchange_rate }}"
                    class="input"
                    placeholder="12000">
            </div>

            <div>
                <label for="vat" class="block mb-2 text-sm font-medium text-gray-900">Vat (%)</label>
                <div class="flex items-center gap-4">
                    <div class="inline-flex items-center">
                        <label class="flex items-center cursor-pointer relative">
                            <input type="checkbox" checked
                                class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                                id="check_vat" />
                            <span
                                class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                                <i class="fa-solid fa-check fa-sm"></i>
                            </span>
                        </label>
                    </div>
                    <input type="number" id="vat" name="vat" value="{{ $order->vat }}"
                        class="input disabled:bg-gray-200 disabled:cursor-not-allowed"
                        placeholder="vat">
                    <span class="text-gray-900 text-xl mr-2">%</span>
                </div>
            </div>

            <input type="hidden" class="text-black" name="total" value="{{ $order->total }}">
            <input type="hidden" class="text-black" name="vat_total" value="{{ $order->vat_total }}">
            <input type="hidden" class="text-black" name="grand_total" value="{{ $order->grand_total }}">

        </div>

        {{-- DEPOSIT --}}
        <h2 class="text-gray-900 font-semibold text-xl py-4">Deposit</h2>
        <hr class="mb-4">
        <div class="grid gap-6 mb-6 md:grid-cols-4">

            <div class="md:col-span-1">
                <label for="deposit_amount" class="block mb-2 text-sm font-medium text-gray-900">Deposti Amount
                    <span class="uppercase">({{ $order->currency }})</span></label>
                <input type="number" id="deposit_amount" name="deposit_amount"
                    value="{{ $order->deposit_amount ?? 0 }}"
                    class="input disabled:bg-gray-200 disabled:cursor-not-allowed"
                    placeholder="Deposit Amount">
            </div>

            <div class="md:col-span-3">
                <label for="deposit_description" class="block mb-2 text-sm font-medium text-gray-900">Deposit
                    Description</label>
                <input type="text" id="deposit_description" name="deposit_description"
                    value="{{ $order->deposit_description }}"
                    class="input"
                    placeholder="Deposit Description">
            </div>

        </div>

        {{-- Terms and conditions  --}}
        <h2 class="text-gray-900 font-semibold text-xl py-4">Terms and Conditions</h2>
        <hr class="mb-4">
        <div class="mb-6">
            <textarea id="terms_conditions" name="terms_conditions" rows="4" class="input h-60"
                    placeholder="Write product description here">{!! $order->terms_conditions !!}
            </textarea>
            {{-- <input type="text" name="terms_conditions" id="terms_conditions" class="text-black"> --}}
            {{-- <x-wysiwyg-flowbite></x-wysiwyg-flowbite> --}}
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('order.index') }}"
                class="button-back">
                Back to Order
            </a>
            <button type="submit"
                class="button-submit">
                Submit
            </button>
        </div>
    </form>

    {{-- MODAL --}}
    <x-customer-modal :customers="$customers" />

    @push('scripts')
        {{-- <script src="{{ asset('quill/quill.js') }}"></script>
        <script>
            const checkboxVat = document.getElementById('check_vat');
            const vatInput = document.getElementById('vat');
            const form = document.querySelector('form');

            // Add an event listener to the checkboxVat
            checkboxVat.addEventListener('change', function() {
                if (checkboxVat.checked) {
                    vatInput.value = '0';
                    vatInput.removeAttribute('disabled');
                } else {
                    vatInput.value = '0';
                    vatInput.setAttribute('disabled', 'disabled');
                }
            });



            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            quill.root.style.color = '#111';

            form.addEventListener('submit', function() {
                const termsConditionsInput = document.getElementById('terms_conditions');
                console.log('hiii');

                termsConditionsInput.value = quill.root.innerHTML;
            });
        </script> --}}
        <script>
            // modal variable
            const button = document.getElementById('modal-button');
            const modal = document.getElementById('default-modal');
            const closeModalButton = document.getElementById('close-modal');
            const resetCustomerButton = document.getElementById('reset-customer');

            // Customer variable
            const customerId = document.getElementById('customer_id')
            const customerName = document.getElementById('customer_name')
            const customerEmail = document.getElementById('customer_email')
            const customerPhone = document.getElementById('customer_phone')
            const customerCountry = document.getElementById('customer_country')

            button.addEventListener('click', function() {
                modal.classList.remove("hidden");
            });

            // Function to close the modal
            function closeModal() {
                modal.classList.add("hidden");
            }

            // Event listener to close the modal when clicking the close button
            closeModalButton.addEventListener('click', closeModal);
            resetCustomerButton.addEventListener('click', resetCustomer);

            // Event listener to close the modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            }

            function resetCustomer() {
                customerId.value = '';
                customerName.value = '';
                customerEmail.value = '';
                customerPhone.value = '';
                customerCountry.value = '';

                // customerId.removeAttribute('readonly');
                customerName.removeAttribute('readonly');
                customerEmail.removeAttribute('readonly');
                customerPhone.removeAttribute('readonly');
                customerCountry.removeAttribute('readonly');
                closeModal();
            }

            function selectCustomer(id, name, email, phone, country) {
                customerId.value = id;
                customerName.value = name;
                customerEmail.value = email;
                customerPhone.value = phone;
                customerCountry.value = country;

                // customerId.setAttribute('readonly', true);
                customerName.setAttribute('readonly', true);
                customerEmail.setAttribute('readonly', true);
                customerPhone.setAttribute('readonly', true);
                customerCountry.setAttribute('readonly', true);
                closeModal();
            }
        </script>

        <script>
            const checkbox = document.getElementById('check');
            const vatInput = document.getElementById('vat');

            // Add an event listener to the checkbox
            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    vatInput.value = '0';
                    vatInput.removeAttribute('disabled');
                } else {
                    vatInput.value = '0';
                    vatInput.setAttribute('disabled', 'disabled');
                }
            });
        </script>

        <script>
            const checkbox = document.getElementById('check');
            const vatInput = document.getElementById('vat');

            // Add an event listener to the checkbox
            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    vatInput.value = '0';
                    vatInput.removeAttribute('disabled');
                } else {
                    vatInput.value = '0';
                    vatInput.setAttribute('disabled', 'disabled');
                }
            });
        </script>

        <script>
            // exchange rate variable
            const exchange = document.getElementById('exchange');
            const currency = document.getElementById('currency');

            currency.addEventListener('change', function() {
                if (currency.value == 'idr') {
                    exchange.value = 1;
                    exchange.setAttribute('readonly', 'readonly')
                    exchange.removeAttribute('required')
                } else {
                    exchange.value = '';
                    exchange.removeAttribute('readonly')
                    exchange.setAttribute('required', 'required')
                }
            })

            if (currencySelect.value === 'idr') {
                exchange.value = 1;
                exchange.setAttribute('readonly', 'readonly');
                exchange.removeAttribute('required')
            }
        </script>

        <script type="module" src="">

        </script>
    @endpush

</x-layout>
