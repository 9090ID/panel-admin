<?php

namespace App\Exports;

use App\Models\KalenderAkademik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class KalenderAkademikExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    protected $tahunAkademikId;

    public function __construct($tahunAkademikId)
    {
        $this->tahunAkademikId = $tahunAkademikId;
    }

    public function collection()
    {
        return KalenderAkademik::where('tahun_akademik_id', $this->tahunAkademikId)->get();
    }

    public function headings(): array
    {
        // Ambil data tahun akademik untuk ditampilkan di header
        $tahunAkademik = \App\Models\TahunAkademik::find($this->tahunAkademikId);
        
        // Header yang akan ditampilkan
        return [
            ['Kalender Akademik Insitut Islam Muaro Jambi'],
            ['Tahun Akademik', ': ' . $tahunAkademik->nama_tahun],
            ['Semester', ': ' . $tahunAkademik->semester],
            ['Tanggal', 'Agenda']
        ];
    }

    public function map($kalenderAkademik): array
    {
        // Format tanggal dalam bahasa Indonesia
        $tanggalMulai = \Carbon\Carbon::parse($kalenderAkademik->tanggal_mulai)->translatedFormat('d F Y');
        $tanggalSelesai = \Carbon\Carbon::parse($kalenderAkademik->tanggal_selesai)->translatedFormat('d F Y');

        // Gabungkan tanggal mulai dan tanggal selesai
        $tanggal = $tanggalMulai . ' s.d ' . $tanggalSelesai;

        return [
            $tanggal, // Tanggal dalam satu kolom
            $kalenderAkademik->nama_event, // Nama Event
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30, // Lebar kolom untuk Tanggal
            'B' => 25, // Lebar kolom untuk Nama Event
        ];
    }
}