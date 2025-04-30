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

        <x-table-header
            :dataset="$customersName"
            :create="'Create Customer'"
            :routeReset="route('customer.index')"
            :routeCreate="route('customer.create')"
        />

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
