<?php

namespace App\Exports;

use App\Models\Guest;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class GuestsExport
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
        $sheet->setTitle('Data Tamu');

        // Set headers
        $headers = [
            'A1' => 'Nama Tamu',
            'B1' => 'Jenis Kelamin',
            'C1' => 'Kategori',
            'D1' => 'Nomor Kontak',
            'E1' => 'Alamat',
            'F1' => 'Status Kehadiran',
            'G1' => 'Waktu Kedatangan',
            'H1' => 'Status Undangan'
        ];

        // Apply headers
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style headers
        $headerRange = 'A1:H1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
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

        // Get guests data
        $guests = Guest::where('invitation_id', $this->invitation_id)
            ->select(
                'guest_name',
                'guest_gender',
                'guest_category',
                'guest_contact',
                'guest_address',
                'guest_attendance_status',
                'guest_arrival_time',
                'guest_invitation_status'
            )
            ->orderBy('guest_name')
            ->get();

        // Add data rows
        $row = 2;
        foreach ($guests as $guest) {
            $sheet->setCellValue('A' . $row, $guest->guest_name);
            $sheet->setCellValue('B' . $row, $guest->guest_gender);
            $sheet->setCellValue('C' . $row, $guest->guest_category);
            $sheet->setCellValue('D' . $row, "'" . $guest->guest_contact); // Prefix apostrophe untuk text
            $sheet->setCellValue('E' . $row, $guest->guest_address);
            $sheet->setCellValue('F' . $row, $guest->guest_attendance_status);
            
            // Format arrival time
            $arrivalTime = $guest->guest_arrival_time;
            if ($arrivalTime && $arrivalTime != '-') {
                $arrivalTime = \Carbon\Carbon::parse($arrivalTime)->format('d/m/Y H:i');
            }
            $sheet->setCellValue('G' . $row, $arrivalTime);
            
            $sheet->setCellValue('H' . $row, $guest->guest_invitation_status);

            // Style data rows
            $dataRange = 'A' . $row . ':H' . $row;
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ]);

            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return $spreadsheet;
    }

    public function download($filename = null)
    {
        $spreadsheet = $this->export();
        
        if (!$filename) {
            $filename = 'data_tamu_' . date('Y-m-d_H-i-s') . '.xlsx';
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
