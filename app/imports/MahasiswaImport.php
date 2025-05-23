<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
     * Import setiap baris dari file Excel.
     *
     * @param array $row Data dari file Excel
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        // Log data untuk memastikan terbaca dengan benar
      
        // Validasi jika ada kolom yang kosong
        if (empty($row['nama']) || empty($row['nim']) || empty($row['prodi']) || empty($row['angkatan']) || empty($row['no_hp']) || empty($row['alamat']) || empty($row['email'])) {
            throw new \Exception('Data tidak lengkap pada baris: ' . json_encode($row));
        }

        // Validasi NIM unik
        if (Mahasiswa::where('nim', $row['nim'])->exists()) {
            throw new \Exception('NIM duplikat ditemukan: ' . $row['nim']);
        }

        // Cari prodi berdasarkan nama
        $prodi = Prodi::where('namaprodi', 'like', '%' . trim($row['prodi']) . '%')->first();

        if (!$prodi) {
            throw new \Exception('Prodi tidak ditemukan untuk: ' . $row['prodi']);
        }
        // Buat user baru dengan NIM sebagai username dan password default
        $user = User::create([
            'name' => $row['nama'],
            'email' => $row['email'], // Anda bisa menggunakan email yang berbeda jika diperlukan
            'username' => $row['nim'],
            'password' => Hash::make($row['nim']), // Password default adalah NIM
            'role' => 'user', // Atur role sesuai kebutuhan
        ]);

        // Siapkan data mahasiswa
        $dataMahasiswa = [
            'nama' => $row['nama'],
            'nim' => $row['nim'],
            'prodi_id' => $prodi->id,
            'angkatan' => $row['angkatan'],
            'no_hp' => $row['no_hp'],
            'alamat' => $row['alamat'],
            'email' => $row['email'],
            'user_id' => $user->id, // Hubungkan dengan user
        ];

        // Simpan data mahasiswa
        Mahasiswa::create($dataMahasiswa);
    }
}
