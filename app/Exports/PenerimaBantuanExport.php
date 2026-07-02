<?php

namespace App\Exports;

use App\Models\PenerimaBantuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell; 
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenerimaBantuanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell 
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

    public function startCell(): string
    {
        return 'A3'; 
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
        $tahun = now()->format('Y'); 

        $sheet->setCellValue('A1', 'Rekap Penerima Bantuan Tahun ' . $tahun);
        $sheet->mergeCells('A1:J1'); 

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

        $sheet->getStyle('A3:J3')->applyFromArray([
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

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A3:J{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getStyle("A4:A{$lastRow}")->getAlignment()->setHorizontal('center');

        for ($row = 4; $row <= $lastRow; $row++) {
            $statusCell = $sheet->getCell("F{$row}")->getValue();
            if ($statusCell === 'Aktif') {
                $sheet->getStyle("F{$row}")->getFont()->getColor()->setRGB('059669');
            } elseif ($statusCell === 'Nonaktif') {
                $sheet->getStyle("F{$row}")->getFont()->getColor()->setRGB('D97706');
            } elseif ($statusCell === 'Dicabut') {
                $sheet->getStyle("F{$row}")->getFont()->getColor()->setRGB('DC2626');
            }
        }

        return [];
    }
}