<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    <x-header title="Edit Customer" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Customers', 'url' => route('customer.index')],
        ['label' => 'Edit Customers', 'url' => route('customer.edit', $customer->id)],
    ]" />

    {{-- FORM --}}
    <form action="{{ route('customer.update', $customer->id) }}" method="POST"
        class="wrapper">
        @csrf
        @method('PUT')

        {{-- CUSTOMER --}}
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                    Customer Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ $customer->name }}"
                    class="input"
                    placeholder="John Doe">
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Customer Email</label>
                <input type="email" id="email" name="email" value="{{ $customer->email }}"
                    class="input"
                    placeholder="example@example.com">
            </div>

        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-3">

            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Customer Phone</label>
                <input type="text" id="phone" name="phone" value="{{ $customer->phone }}"
                    class="input"
                    placeholder="123-456-7890">
            </div>

            <div>
                <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Customer
                    Country</label>
                <input type="text" id="country" name="country" value="{{ $customer->country }}"
                    class="input"
                    placeholder="Country">
            </div>

            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                <select id="status" name="status"
                    class="select">
                    <option value="Common" {{ $customer->status == 'Common' ? 'selected' : '' }}>Common</option>
                    <option value="Member" {{ $customer->status == 'Member' ? 'selected' : '' }}>Member</option>
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
