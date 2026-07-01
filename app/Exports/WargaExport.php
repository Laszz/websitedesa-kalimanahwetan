<?php

namespace App\Exports;

use App\Models\Warga\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WargaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        // Header style
        $sheet->getStyle('A1:P1')->applyFromArray([
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

        // Auto width for all columns
        foreach (range('A', 'P') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border for all cells
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:P{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Center alignment for No column
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal('center');

        return [];
    }
}