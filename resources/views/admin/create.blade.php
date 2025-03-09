<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-alret />

    {{-- HEADER --}}
    <x-header title="Create Admin" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('index')],
        ['label' => 'Admin', 'url' => route('admin.index')],
        ['label' => 'Create Admin', 'url' => route('admin.create')],
    ]" />

    {{-- FORM --}}
    <form action="{{ route('admin.store') }}" method="POST" class="wrapper">
        @csrf
        @method('POST')

        {{-- Admin --}}
        <div class="grid gap-6 mb-6 md:grid-cols-3">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name"
                    class="input"
                    placeholder="John Doe">
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email Name <span
                        class="text-red-500">*</span></label>
                <input type="email" id="email" name="email"
                    class="input"
                    placeholder="example@example.com">
            </div>

            <div>
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role Name <span
                        class="text-red-500">*</span></label>
                <select id="role" name="role"
                    class="select">
                    <option value="admin">Admin</option>
                    <option value="super.admin">Super Admin</option>
                </select>
            </div>
        </div>

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password
                    <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password"
                    class="input"
                    placeholder="Password">
            </div>

            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password
                    <span class="text-red-500">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="input"
                    placeholder="Confirm Password">
            </div>
        </div>


        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.index') }}"
                class="button-back">
                Back to Admin
            </a>
            <button type="submit"
                class="button-submit">
                Submit
            </button>
        </div>
    </form>

</x-layout>
