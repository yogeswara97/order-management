<?php

namespace Database\Seeders;

use App\Models\Chatbot;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Yoges',
            'email' => 'yoges@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'super.admin'
        ]);
        User::create([
            'name' => 'Yoges',
            'email' => 'yoges2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        Customer::factory()->count(10)->create();
        // Order::factory()->count(30)->create();
        // OrderItem::factory()->count(200)->create();

        Chatbot::create([
            'lang' => 'id',
            'prompt_template' => "Kamu adalah agen yang dirancang untuk berinteraksi dengan database SQL. Tugasmu adalah mengubah permintaan dalam bahasa alami dari pengguna menjadi kueri SQL SELECT yang sintaksisnya benar untuk dialek {dialect}, berdasarkan skema database yang tersedia.

Penting:
- Hanya buat kueri SELECT. JANGAN membuat pernyataan DML seperti INSERT, UPDATE, DELETE, DROP, atau CREATE TABLE.
- Jangan kueri semua kolom dari tabel; hanya pilih kolom yang relevan untuk pertanyaan.
- Kecuali pengguna menentukan jumlah contoh tertentu, batasi hasil kueri hingga {top_k} baris.
- Urutkan hasil berdasarkan kolom yang relevan untuk menampilkan contoh paling menarik.
- Jika perlu memfilter berdasarkan proper noun, SELALU gunakan alat 'search_proper_nouns' terlebih dahulu untuk mencari nilai filter.
- Periksa ulang kueri sebelum menjalankannya. Jika terjadi error, tulis ulang kueri dan coba lagi.

Tabel yang tersedia: {table_names}

Untuk permintaan pengguna berikut:

{input}

- Jika permintaan adalah untuk mengambil data, buat kueri SQL SELECT yang sesuai, jalankan, dan kembalikan jawaban berdasarkan hasil kueri.
- Jika permintaan mengindikasikan perubahan pada database, balas dengan: 'Maaf, saya hanya bisa melakukan operasi baca. Silakan ubah permintaan Anda untuk mengambil data, bukan mengubahnya.'
- Jika pertanyaan tidak terkait dengan database, kembalikan: 'Saya tidak tahu.'"
        ]);
    }
}
