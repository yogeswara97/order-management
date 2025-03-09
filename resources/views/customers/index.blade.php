<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    <x-header title="Customers" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Customers', 'url' => route('customer.index')],
    ]" />


    {{-- TABLE --}}
    <div class="overflow-x-auto rounded-2xl border border-gray-200">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/4">
                <form class="flex items-center" method="GET" action="{{ route('customer.index') }}">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-900">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" id="simple-search" name="search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full pl-10 p-2"
                            placeholder="Search by name" value="{{ request('search') }}" required="">
                    </div>
                </form>
            </div>
            <div
                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                <a href="{{ route('customer.index') }}" class="button-delete">
                    Reset Filter
                </a>
                <a href="{{ route('customer.create') }}" class="button-add">
                    Create Customer
                </a>
            </div>
        </div>

        <x-table :headers="['Name', 'Email', 'Phone', 'Status', 'Country', 'Action']">
            @foreach ($customers as $customer)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $customer->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $customer->email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $customer->phone }}
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class=" flex items-center justify-center p-2  rounded-md
                                @if ($customer->status == 'Member') bg-green-400 text-green-950 bg-opacity-60 @endif
                            ">
                            {{ $customer->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $customer->country }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="space-x-2 flex">
                            <a href="{{ route('customer.show', $customer->id) }}" class="button-mini-show">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('customer.edit', $customer->id) }}" class="button-mini-edit">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <form action="{{ route('customer.destroy', $customer->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this Customer? {{ $customer->name }}')"
                                    class="button-mini-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>
        <x-table-navigation :dataset="$customers" :perPage="$perPage" />
    </div>
</x-layout>
