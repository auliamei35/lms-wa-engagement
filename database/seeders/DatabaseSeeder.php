<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
   {
       // 1. Buat User Contoh
       \App\Models\User::create([
          'name' => 'Aulia Test',
          'email' => 'aulia@example.com',
          'password' => bcrypt('password'),
          'phone' => '6281234567890', // Gunakan format 62
        ]);

      // 2. Buat Tugas Contoh (Satu sudah lewat deadline, satu belum)
      \App\Models\Task::create([
          'title' => 'Tugas Laravel Dasar',
          'description' => 'Membangun sistem CRUD sederhana',
          'deadline' => now()->subDay(), // H-1 (Ini yang akan memicu reminder)
        ]);

      \App\Models\Task::create([
          'title' => 'Tugas Database PostgreSQL',
          'description' => 'Merancang skema database engagement',
          'deadline' => now()->addDays(2), // Masih aman
      ]);
    }
}
