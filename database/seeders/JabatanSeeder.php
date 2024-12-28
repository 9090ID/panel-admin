<?php

namespace Database\Seeders;
use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Jabatan::create(['namajabatan' => 'Manager', 'status' => 'aktif']);
        Jabatan::create(['namajabatan' => 'Supervisor', 'status' => 'aktif']);
        Jabatan::create(['namajabatan' => 'Staff', 'status' => 'non_aktif']);
    }
}
