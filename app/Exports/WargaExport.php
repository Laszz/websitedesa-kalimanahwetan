<?php

namespace App\Exports;

use App\Models\Warga\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WargaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell, WithEvents
{
    protected $wargas;
    protected $dataCount = 0;

    public function __construct($wargas = null)
    {
        $this->wargas = $wargas;
    }

    public function collection()
    {
        $collection = $this->wargas ?? Warga::with('user')->get();
        $this->dataCount = $collection->count();
        return $collection;
    }

    public function startCell(): string
    {
        return 'A4'; // ← PINDAH: Header sekarang mulai dari baris 4 (baris 1 judul, baris 2 sub-judul, baris 3 kosong)
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
        $tahun = now()->format('Y');

        // === JUDUL ATAS (Baris 1) ===
        $sheet->setCellValue('A1', 'Rekap Kelola Warga Tahun ' . $tahun);
        $sheet->mergeCells('A1:O1');

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

        // === SUB-JUDUL (Baris 2) ===
        $sheet->setCellValue('A2', 'Desa Kalimanah Wetan');
        $sheet->mergeCells('A2:O2');

        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '475569'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $sheet->getRowDimension('2')->setRowHeight(25);

        // === HEADER (Baris 4) ===
        $sheet->getStyle('A4:O4')->applyFromArray([
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

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Hitung baris terakhir data (header di baris 4, data mulai baris 5)
                $lastDataRow = 4 + $this->dataCount;

                // Border untuk header + data
                $sheet->getStyle("A4:O{$lastDataRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Center alignment untuk No
                $sheet->getStyle("A5:A{$lastDataRow}")->getAlignment()->setHorizontal('center');
            },
        ];
    }
}