<?php

namespace App\Exports;

use App\Models\Warga\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell; 
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WargaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell 
{
    protected $wargas;

    public function __construct($wargas = null)
    {
        $this->wargas = $wargas;
    }

    public function collection()
    {
        if ($this->wargas) {
            return $this->wargas;
        }
        return Warga::with('user')->get();
    }

    // ← TAMBAH: Tentukan cell mulai
    public function startCell(): string
    {
        return 'A3'; // Header mulai dari baris 3, baris 1-2 untuk judul
    }

    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'No. KK',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Umur',
            'Jenis Kelamin',
            'Agama',
            'Status',
            'Pendidikan Akhir',
            'Pekerjaan',
            'Alamat',
            'RW',
            'RT',
        ];
    }

    public function map($warga): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            "'" . $warga->nik,
            "'" . $warga->kk,
            $warga->name,
            $warga->tempat_lahir,
            $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d/m/Y') : '-',
            $warga->umur,
            $warga->jenis_kelamin,
            $warga->agama,
            $warga->status,
            $warga->pendidikan_akhir,
            $warga->pekerjaan,
            $warga->alamat,
            $warga->rw,
            $warga->rt,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $tahun = now()->format('Y'); // Tahun sekarang otomatis

        // === JUDUL (Baris 1) ===
        $sheet->setCellValue('A1', 'Rekap Kelola Warga Tahun ' . $tahun);
        $sheet->mergeCells('A1:O1'); // Merge sesuai jumlah kolom (15 kolom = A-O)

        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '1e293b'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $sheet->getRowDimension('1')->setRowHeight(30);

        // === HEADER (Baris 3) ===
        $sheet->getStyle('A3:O3')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Auto width
        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border untuk semua data
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A3:O{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Center alignment untuk No
        $sheet->getStyle("A4:A{$lastRow}")->getAlignment()->setHorizontal('center');

        return [];
    }
}