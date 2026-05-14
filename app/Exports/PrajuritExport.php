<?php

namespace App\Exports;

use App\Models\Prajurit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PrajuritExport implements FromCollection, WithHeadings, WithEvents, WithColumnFormatting
{
    protected $range;
    protected $angkatan;
    protected $periode;

    public function __construct($range, $angkatan, $periode = null)
    {
        $this->range   = $range;
        $this->angkatan = $angkatan;
        $this->periode  = $periode;
    }

    public function collection()
{
    $query = Prajurit::query();

    // Filter range waktu
    if ($this->range === '1bulan') {
        $query->where('created_at', '>=', now()->subMonth());
    } elseif ($this->range === '3bulan') {
        $query->where('created_at', '>=', now()->subMonths(3));
    } elseif ($this->range === '1tahun') {
        $query->where('created_at', '>=', now()->subYear());
    }

    // Filter angkatan
    if (!empty($this->angkatan)) {
        $query->where('angkatan', $this->angkatan);
    }

    return $query->select([
        'name',
        'nrp',
        'korp',
        'nik',
        'pangkat',
        'angkatan',
        'gender',
        'satuan_asal',
        'satuan_baru',
        'no_kep',
        'tgl_kep',
        'no_sprin',
        'tgl_sprin',
        'no_hp',
        'alamat',
    ])->get()->map(function ($item) {
        $item->nrp = "\t" . $item->nrp;
        $item->nik = "\t" . $item->nik;
        return $item;
    });
}


    public function headings(): array
    {
        return [
            'Nama', 
            'NRP', 
            'KORP', 
            'NIK', 
            'Pangkat',
            'Matra',
            'Jenis Kelamin',
            'Satuan Asal', 
            'Satuan Baru', 
            'No Kep', 
            'Tgl Kep',
            'No Sprint', 
            'Tgl Sprint',
            'No HP', 
            'Alamat', 
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $event->sheet->appendRows([
                    ["Laporan Prajurit Angkatan {$this->angkatan}"],
                    ["Periode: {$this->periode}"],
                    [""], 
                ], $event);
            },
        ];
    }

    /**
     * 🧾 Format kolom agar NRP & NIK terbaca sebagai teks di Excel
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT, // Kolom NRP
            'D' => NumberFormat::FORMAT_TEXT, // Kolom NIK
        ];
    }
}
