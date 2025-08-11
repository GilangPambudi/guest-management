<?php

namespace App\Exports;

use App\Models\Wish;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class WishesExport
{
    protected $invitation_id;

    public function __construct($invitation_id)
    {
        $this->invitation_id = $invitation_id;
    }

    public function export()
    {
        // Create new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Ucapan & Doa');

        // Set headers
        $headers = [
            'A1' => 'Nama Tamu',
            'B1' => 'Kategori Tamu',
            'C1' => 'Ucapan & Doa',
            'D1' => 'Tanggal Ucapan'
        ];

        // Apply headers
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style headers
        $headerRange = 'A1:D1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '28A745'] // Green color for wishes
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Get wishes data with guest info
        $wishes = Wish::with('guest')
            ->where('invitation_id', $this->invitation_id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Add data rows
        $row = 2;
        foreach ($wishes as $wish) {
            $sheet->setCellValue('A' . $row, $wish->guest->guest_name ?? 'Anonymous');
            $sheet->setCellValue('B' . $row, $wish->guest->guest_category ?? '-');
            $sheet->setCellValue('C' . $row, $wish->message);
            
            // Format created_at
            $createdAt = $wish->created_at ? $wish->created_at->format('d/m/Y H:i') : '-';
            $sheet->setCellValue('D' . $row, $createdAt);

            // Style data rows
            $dataRange = 'A' . $row . ':D' . $row;
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true // Enable text wrapping for message column
                ]
            ]);

            // Set specific alignment for message column (left-aligned, wrapped)
            $sheet->getStyle('C' . $row)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true
                ]
            ]);

            $row++;
        }

        // Auto-size columns except message column
        foreach (['A', 'B', 'D'] as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set specific width for message column (wider for better readability)
        $sheet->getColumnDimension('C')->setWidth(50);

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Set minimum row height for data rows to accommodate wrapped text
        for ($i = 2; $i < $row; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(30);
        }

        return $spreadsheet;
    }

    public function download($filename = null)
    {
        $spreadsheet = $this->export();
        
        if (!$filename) {
            $filename = 'ucapan_doa_' . date('Y-m-d_H-i-s') . '.xlsx';
        }

        // Create writer
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        // Save to output
        $writer->save('php://output');
        exit;
    }
}
