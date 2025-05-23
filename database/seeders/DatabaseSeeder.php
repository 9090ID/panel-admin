<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Buat Permission
    // Buat role admin jika belum ada
    $role = Role::firstOrCreate(['name' => 'admin']);

    // Temukan user pertama
    $user = User::find(1); // Sesuaikan dengan user ID yang ada
    $user->assignRole('admin');
    }
}
