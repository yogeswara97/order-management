<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    <x-header title="Admin" :breadcrumbs="[['label' => 'Home', 'url' => route('index')], ['label' => 'Admin', 'url' => route('admin.index')]]" />

    {{-- TABLE --}}
    <div class="overflow-x-auto rounded-2xl border border-gray-200">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/4">
                <form class="flex items-center" method="GET" action="{{ route('admin.index') }}">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input type="text" id="simple-search" name="search"
                            class="input"
                            placeholder="Search by name" value="{{ request('search') }}" autocomplete="off">
                        <div class="relative" id="customer-list">
                            <ul id="dropdown-list"
                                class="absolute z-50 top-full left-0 w-full max-h-48 overflow-y-auto text-sm text-gray-700 rounded-b-lg shadow-lg bg-gray-50 hidden">
                                @foreach ($adminsName as $adminName)
                                    <li class="customer-item">
                                        <div class="flex items-center ps-2 rounded-sm hover:bg-gray-100 cursor-pointer">
                                            <label for="checkbox-item-11"
                                                class="w-full py-2 text-sm font-medium text-gray-900 rounded-sm">{{ $adminName->name }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="submit" class="button-submit ml-4">
                        Filter
                    </button>
                </form>
            </div>
            @if (session('user')['role'] == 'super.admin')
                <div
                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <a href="{{ route('admin.index') }}" class="button-delete">
                        Reset Filter
                    </a>
                    <a href="{{ route('admin.create') }}" class="button-add">
                        Create Admin
                    </a>
                </div>
            @endif
        </div>


        @php
            $headers = ['Name', 'Email', 'role'];

            if (session('user')['role'] == 'super.admin') {
                $headers[] = 'Action';
            }
        @endphp

        <x-table :headers="$headers">
            @foreach ($admins as $admin)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $admin->name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $admin->email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $admin->role == 'super.admin' ? 'Super Admin' : 'Admin' }}
                    </td>

                    @if (session('user')['role'] == 'super.admin')
                        <td class="px-6 py-4">
                            <div class="space-x-2 flex">

                                <a href="{{ route('admin.edit', $admin->id) }}" class="button-mini-edit">
                                    <i class="fas fa-pencil"></i>
                                </a>


                                <form action="{{ route('admin.destroy', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this admin? {{ $admin->name }}')"
                                        class="button-mini-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </x-table>

        <x-table-navigation :dataset="$admins" :perPage="$perPage" />
    </div>


    @push('scripts')
        <script src="{{ asset('js/search-input.js') }}"></script>
    @endpush
</x-layout>
