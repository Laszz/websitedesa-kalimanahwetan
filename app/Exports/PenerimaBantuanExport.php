<?php

namespace App\Exports;

use App\Models\PenerimaBantuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenerimaBantuanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell, WithEvents
{
    protected $penerimaBantuans;
    protected $dataCount = 0;

    public function __construct($penerimaBantuans = null)
    {
        $this->penerimaBantuans = $penerimaBantuans;
    }

    public function collection()
    {
        $collection = $this->penerimaBantuans ?? PenerimaBantuan::with(['warga', 'jenisBantuan', 'creator'])->get();
        $this->dataCount = $collection->count();
        return $collection;
    }

    public function startCell(): string
    {
        return 'A4'; // ← PINDAH: Header mulai dari baris 4
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

        // === JUDUL ATAS (Baris 1) ===
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

        // === SUB-JUDUL (Baris 2) ===
        $sheet->setCellValue('A2', 'Desa Kalimanah Wetan');
        $sheet->mergeCells('A2:J2');

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
        $sheet->getStyle('A4:J4')->applyFromArray([
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

        // Auto width
        foreach (range('A', 'J') as $col) {
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
                $sheet->getStyle("A4:J{$lastDataRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Center alignment untuk No
                $sheet->getStyle("A5:A{$lastDataRow}")->getAlignment()->setHorizontal('center');

                // Status color coding
                for ($row = 5; $row <= $lastDataRow; $row++) {
                    $statusCell = $sheet->getCell("F{$row}")->getValue();
                    if ($statusCell === 'Aktif') {
                        $sheet->getStyle("F{$row}")->getFont()->getColor()->setRGB('059669');
                    } elseif ($statusCell === 'Nonaktif') {
                        $sheet->getStyle("F{$row}")->getFont()->getColor()->setRGB('D97706');
                    } elseif ($statusCell === 'Dicabut') {
                        $sheet->getStyle("F{$row}")->getFont()->getColor()->setRGB('DC2626');
                    }
                }
            },
        ];
    }
}