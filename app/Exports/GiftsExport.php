<?php

namespace App\Exports;

use App\Models\Payment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class GiftsExport
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
        $sheet->setTitle('Data Kado');

        // Set headers
        $headers = [
            'A1' => 'Nama Pemberi',
            'B1' => 'Kategori Tamu',
            'C1' => 'ID Transaksi',
            'D1' => 'Nominal (Rp)',
            'E1' => 'Status Pembayaran',
            'F1' => 'Metode Pembayaran',
            'G1' => 'Tanggal Transaksi',
            'H1' => 'Tanggal Update'
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
                'startColor' => ['rgb' => 'FFC107'] // Orange/Yellow color for gifts
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

        // Get gifts/payments data with guest info
        $payments = Payment::leftJoin('guests', 'payments.guest_id', '=', 'guests.guest_id')
            ->where('payments.invitation_id', $this->invitation_id)
            ->select(
                'payments.payment_id',
                'payments.guest_id',
                'payments.order_id',
                'payments.gross_amount',
                'payments.transaction_status',
                'payments.payment_type',
                'payments.created_at',
                'payments.updated_at',
                'guests.guest_name',
                'guests.guest_category'
            )
            ->orderBy('payments.created_at', 'desc')
            ->get();

        // Add data rows
        $row = 2;
        foreach ($payments as $payment) {
            $sheet->setCellValue('A' . $row, $payment->guest_name ?? 'Unknown');
            $sheet->setCellValue('B' . $row, $payment->guest_category ?? '-');
            $sheet->setCellValue('C' . $row, $payment->order_id);
            
            // Format amount as currency
            $formattedAmount = 'Rp ' . number_format($payment->gross_amount, 0, ',', '.');
            $sheet->setCellValue('D' . $row, $formattedAmount);
            
            $sheet->setCellValue('E' . $row, ucfirst($payment->transaction_status));
            $sheet->setCellValue('F' . $row, $payment->payment_type ?: 'Not Set');
            
            // Format transaction time
            $createdAt = $payment->created_at 
                ? $payment->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') 
                : '-';
            $sheet->setCellValue('G' . $row, $createdAt);
            
            // Format updated time
            $updatedAt = $payment->updated_at 
                ? $payment->updated_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') 
                : '-';
            $sheet->setCellValue('H' . $row, $updatedAt);

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

            // Color coding for transaction status
            $statusColor = match($payment->transaction_status) {
                'settlement' => '28A745', // Green
                'pending' => 'FFC107',    // Yellow
                'cancel', 'expire' => 'DC3545', // Red
                'deny' => '6C757D',       // Gray
                default => 'FFFFFF'       // White
            };

            $sheet->getStyle('E' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $statusColor]
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF'],
                    'bold' => true
                ]
            ]);

            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set specific width for some columns
        $sheet->getColumnDimension('C')->setWidth(20); // Order ID
        $sheet->getColumnDimension('D')->setWidth(15); // Amount

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Add summary at the bottom if there's data
        if ($row > 2) {
            $summaryRow = $row + 2;
            
            // Calculate totals
            $totalPayments = $payments->count();
            $totalSettled = $payments->where('transaction_status', 'settlement')->sum('gross_amount');
            $successfulCount = $payments->where('transaction_status', 'settlement')->count();
            
            // Add summary
            $sheet->setCellValue('A' . $summaryRow, 'RINGKASAN:');
            $sheet->setCellValue('A' . ($summaryRow + 1), 'Total Transaksi:');
            $sheet->setCellValue('B' . ($summaryRow + 1), $totalPayments);
            $sheet->setCellValue('A' . ($summaryRow + 2), 'Transaksi Berhasil:');
            $sheet->setCellValue('B' . ($summaryRow + 2), $successfulCount);
            $sheet->setCellValue('A' . ($summaryRow + 3), 'Total Nominal Berhasil:');
            $sheet->setCellValue('B' . ($summaryRow + 3), 'Rp ' . number_format($totalSettled, 0, ',', '.'));

            // Style summary
            $sheet->getStyle('A' . $summaryRow . ':B' . ($summaryRow + 3))->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F8F9FA']
                ]
            ]);
        }

        return $spreadsheet;
    }

    public function download($filename = null)
    {
        $spreadsheet = $this->export();
        
        if (!$filename) {
            $filename = 'data_kado_' . date('Y-m-d_H-i-s') . '.xlsx';
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
