{{-- resources/views/components/customer-modal.blade.php --}}
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-7xl max-h-full">

        <div class="relative bg-white rounded-lg shadow-sm ">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    Customer List
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    id="close-modal" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4 overflow-y-auto overflow-x-hidden max-h-[35rem]">
                <div class="w-full md:w-1/4">
                    <div class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-900">
                                <i class="fas fa-search"></i>
                            </div>
                            <input type="text" id="simple-search" name="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full pl-10 p-2"
                                placeholder="Search by name" value="" required="">
                        </div>
                    </div>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-5">Name</th>
                            <th scope="col" class="px-6 py-5">Email</th>
                            <th scope="col" class="px-6 py-5">Phone</th>
                            <th scope="col" class="px-6 py-5">Country</th>
                            <th scope="col" class="px-6 py-5">Action</th>
                        </tr>
                    </thead>
                    <tbody id="customer-table-body">
                        @foreach ($customers as $customer)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $customer->name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $customer->email }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $customer->phone }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $customer->country }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <button type="button"
                                        onclick="selectCustomer('{{ $customer->id }}','{{ $customer->name }}', '{{ $customer->email }}', '{{ $customer->phone }}', '{{ $customer->country }}')"
                                        class="button-mini-add">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('simple-search');
            const tableBody = document.getElementById('customer-table-body');
            const rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase()

                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let match = false;

                    for (let j = 0; j < cells.length; j++) {
                        const cellText = cells[j].textContent || cells[j].innerText;
                        if (cellText.toLowerCase().indexOf(searchTerm) > -1) {
                            match = true
                            break;
                        }
                    }
                    if (match) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }

            })
        })
    </script>
@endpush
