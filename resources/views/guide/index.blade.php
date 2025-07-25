<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div x-data="{
            section: 'login',
            sections: [
                {
                    id: 'login',
                    label: 'Login & Dashboard',
                    image: '{{ asset('img/guide/login.png') }}',
                    title: 'Login & Dashboard',
                    description: 'Setelah login, kamu akan diarahkan ke dashboard untuk melihat data booking, statistik, dan fitur sesuai role kamu.',

                },
                {
                    id: 'booking',
                    label: 'Manajemen Booking',
                    image: '{{ asset('img/guide/booking.png') }}',
                    title: 'Manajemen Booking',
                    description: 'Lihat daftar booking masuk, status, dan filter berdasarkan tanggal.',
                    cards: [
                        {
                            image: '{{ asset('img/guide/booking-list.png') }}',
                            title: 'Daftar Booking',
                            description: 'Semua booking ditampilkan secara realtime.'
                        },
                        {
                            image: '{{ asset('img/guide/filter.png') }}',
                            title: 'Filter Tanggal',
                            description: 'Memudahkan pencarian data booking.'
                        }
                    ]
                },
                // Tambahkan section lain dengan pola yang sama...
            ]
        }" class="flex flex-col md:flex-row max-w-7xl mx-auto py-10 px-4 space-y-6 md:space-y-0 md:space-x-0">

        <!-- Sidebar -->
        <div class="md:w-1/4 pr-6 border-r border-gray-200">
            <div class="space-y-2">
                <template x-for="item in sections" :key="item.id">
                    <button @click="section = item.id" x-text="item.label" :class="section === item.id
                            ? 'bg-blue-100 text-blue-700 font-semibold'
                            : 'hover:bg-gray-100 text-gray-700'"
                        class="w-full text-left px-4 py-2 rounded-lg text-sm transition"></button>
                </template>
            </div>
        </div>

        <!-- Content -->
        <div class="md:w-3/4 pl-6 space-y-6">
            <template x-for="item in sections" :key="item.id">
                <div x-show="section === item.id" x-transition>
                    <!-- Gambar & Judul -->
                    <div class="mb-6">
                        <img :src="item.image" :alt="item.title"
                            class="w-full max-h-64 object-contain rounded-xl border border-gray-200 mb-4">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2" x-text="item.title"></h2>
                        <p class="text-gray-600" x-text="item.description"></p>
                    </div>

                    <!-- Cards -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <template x-for="card in item.cards" :key="card.title">
                            <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                                <div class="flex items-start gap-4">
                                    <img :src="card.image" :alt="card.title" class="w-16 h-16 object-contain">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-1" x-text="card.title"></h3>
                                        <p class="text-gray-600 text-sm" x-text="card.description"></p>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>
            </template>
        </div>
    </div>
</x-layout>
