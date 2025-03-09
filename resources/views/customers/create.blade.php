<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    {{-- HEADER --}}
    <x-header title="Create Customer" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Customers', 'url' => route('customer.index')],
        ['label' => 'Create Customers', 'url' => route('customer.create')],
    ]" />

    {{-- FORM --}}
    <form action="{{ route('customer.store') }}" method="POST" class="wrapper">
        @csrf
        @method('POST')

        {{-- CUSTOMER --}}
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Customer Name <span
                        class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" class="input" placeholder="John Doe">
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Customer Email</label>
                <input type="email" id="email" name="email" class="input" placeholder="example@example.com">
            </div>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-3">

            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Customer Phone</label>
                <input type="text" id="phone" name="phone" class="input" placeholder="123-456-7890">
            </div>

            <div>
                <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Customer
                    Country</label>
                <input type="text" id="country" name="country" class="input" placeholder="Country">
            </div>

            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                <select id="status" name="status"
                    class="select">
                    <option value="Common">Common</option>
                    <option value="Member">Member</option>
                </select>
            </div>
        </div>


        <div class="flex justify-end gap-2">
            <a href="{{ route('customer.index') }}"
                class="button-back">
                Back to Customers
            </a>
            <button type="submit"
                class="button-submit">
                Submit
            </button>
        </div>
    </form>

</x-layout>
