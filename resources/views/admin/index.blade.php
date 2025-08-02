<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    <x-header title="Admin" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Admin', 'url' => route('admin.index')],
    ]" />

    {{-- TABLE --}}
    <div class="overflow-x-auto rounded-2xl border border-gray-200">
        @php
            $createLabel = session('user')['role'] === 'super.admin' ? 'Create Admin' : null;
        @endphp

        <x-table-header :dataset="$adminsName" :create="$createLabel" :routeReset="route('admin.index')"
            :routeCreate="route('admin.create')" />

        @php
            $headers = ['Name', 'Email', 'role',];

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
</x-layout>
