<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    <x-header title="Create Order" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Orders', 'url' => route('order.index')],
        ['label' => 'Create Order', 'url' => route('order.create')],
    ]" />

    {{-- FORM --}}
    <form action="{{ route('order.store') }}" method="POST" class="wrapper">
        @csrf
        @method('POST')

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
                    Add From Customer List
                </button>
            </div>
        </div>
        <hr class="mb-4">
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            {{-- <label for="customer_id" class="block mb-2 text-sm font-medium text-gray-900">Customer Id</label> --}}
            <input type="hidden" id="customer_id" name="customer_id" readonly
                class="input"
                placeholder="Customer Id here">

            <div>
                <label for="customer_name" class="block mb-2 text-sm font-medium text-gray-900">Customer Name <span
                        class="text-red-500">*</span></label>
                <input type="text" id="customer_name" name="customer_name"
                    class="input"
                    placeholder="John Doe">
            </div>

            <div>
                <label for="customer_email" class="block mb-2 text-sm font-medium text-gray-900">Customer Email</label>
                <input type="email" id="customer_email" name="customer_email"
                    class="input"
                    placeholder="example@example.com">
            </div>

            <div>
                <label for="customer_phone" class="block mb-2 text-sm font-medium text-gray-900">Customer Phone</label>
                <input type="text" id="customer_phone" name="customer_phone"
                    class="input"
                    placeholder="123-456-7890">
            </div>

            <div>
                <label for="customer_country" class="block mb-2 text-sm font-medium text-gray-900">Customer
                    Country</label>
                <input type="text" id="customer_country" name="customer_country"
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
                <input type="date" id="order_date" name="order_date"
                    class="input"
                    value="{{ date('Y-m-d') }}">
            </div>


            <div>
                <label for="reference_number" class="block mb-2 text-sm font-medium text-gray-900">Reference
                    Number</label>
                <input type="text" id="reference_number" name="reference_number"
                    class="input"
                    placeholder="Reference Number">
            </div>

            <div>
                <label for="order_number" class="block mb-2 text-sm font-medium text-gray-900">Order Number</label>
                <input type="text" id="order_number" name="order_number"
                    class="input"
                    placeholder="Order Number" value="">
            </div>

            <div>
                <label for="object" class="block mb-2 text-sm font-medium text-gray-900">Object</label>
                <input type="text" id="object" name="object"
                    class="input"
                    placeholder="object">
            </div>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-5">
            <div>
                <label for="cargo" class="block mb-2 text-sm font-medium text-gray-900">Cargo</label>
                <input type="text" id="cargo" name="cargo"
                    class="input"
                    placeholder="Cargo">
            </div>

            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                <select id="status" name="status"
                    class="select">
                    <option value="new">New</option>
                    <option value="quotation">Quotation</option>
                    <option value="invoice">Invoice</option>
                </select>
            </div>

            <div>
                <label for="currency" class="block mb-2 text-sm font-medium text-gray-900">Currency</label>
                <select id="currency" name="currency"
                    class="select">
                    <option value="usd">USD</option>
                    <option value="eur">EUR</option>
                    <option value="idr">IDR</option>
                </select>
            </div>

            <div>
                <label for="exchange" class="block mb-2 text-sm font-medium text-gray-900">Exchange rate to
                    IDR</label>
                <input type="text" id="exchange" name="exchange_rate"
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
                                id="check" />
                            <span
                                class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                                <i class="fa-solid fa-check fa-sm"></i>
                            </span>
                        </label>
                    </div>
                    <input type="number" id="vat" name="vat"
                        class="input"
                        placeholder="vat">
                    <span class="text-gray-900 text-xl mr-2">%</span>
                </div>
            </div>

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
    @endpush

</x-layout>
