<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    <x-header title="Create Admin" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Admin', 'url' => route('admin.index')],
        ['label' => 'Edit Admin', 'url' => route('admin.edit', $admin->id)],
    ]" />


    {{-- FORM --}}
    <form action="{{ route('admin.update', $admin->id) }}" method="POST" class="wrapper">
        @csrf
        @method('PUT')

        {{-- Admin --}}
        <div class="grid gap-6 mb-6 md:grid-cols-3">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" class="input"
                    value="{{ old('name', $admin->name) }}" placeholder="John Doe">
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email Name <span
                        class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" class="input"
                    value="{{ old('email', $admin->email) }}" placeholder="example@example.com">
            </div>

            <div>
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role Name <span
                        class="text-red-500">*</span></label>
                <select id="role" name="role" class="select">
                    <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super.admin" {{ old('role', $admin->role) == 'super.admin' ? 'selected' : '' }}>Super
                        Admin</option>
                </select>
            </div>
        </div>

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password
                    <span class="text-red-500">*</span></label>
                <input type="text" id="password" name="password" class="input" placeholder="Password">
            </div>

            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password
                    <span class="text-red-500">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="input"
                    placeholder="Password">
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.index') }}"
                class="button-back">
                Back to Admin
            </a>
            <button type="submit"
                class="button-submit">
                Update
            </button>
        </div>
    </form>
</x-layout>
