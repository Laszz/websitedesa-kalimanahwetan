<?php

namespace App\Exports;

use App\Models\PenerimaBantuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenerimaBantuanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $penerimaBantuans;

    public function __construct($penerimaBantuans = null)
    {
        $this->penerimaBantuans = $penerimaBantuans;
    }

    public function collection()
    {
        if ($this->penerimaBantuans) {
            return $this->penerimaBantuans;
        }
        return PenerimaBantuan::with(['warga', 'jenisBantuan', 'creator'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'Nama Warga',
            'Jenis Bantuan',
            'Desil',
            'Status',
            'Tanggal Terima',
            'Keterangan',
            'Dibuat Oleh',
            'Tanggal Dibuat',
        ];
    }

    public function map($pb): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            "'" . ($pb->warga->nik ?? '-'),
            $pb->warga->name ?? '-',
            $pb->jenisBantuan->nama_bantuan ?? '-',
            'Desil ' . $pb->desil,
            ucfirst($pb->status),
            $pb->tanggal_terima ? $pb->tanggal_terima->format('d/m/Y') : '-',
            $pb->keterangan ?? '-',
            $pb->creator->name ?? '-',
            $pb->created_at ? $pb->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '059669'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Auto width for all columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border for all cells
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:J{$lastRow}")->applyFromArray([
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