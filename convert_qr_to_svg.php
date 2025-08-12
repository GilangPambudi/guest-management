<?php

require_once 'vendor/autoload.php';

use App\Models\Guest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Starting QR Code conversion from PNG to SVG...\n";

// Get all guests with QR codes
$guests = Guest::whereNotNull('guest_id_qr_code')
    ->whereNotNull('guest_qr_code')
    ->get();

$convertedCount = 0;
$skippedCount = 0;
$errorCount = 0;

foreach ($guests as $guest) {
    try {
        $oldPath = str_replace('storage/', '', $guest->guest_qr_code);
        $newPath = str_replace('.png', '.svg', $oldPath);
        
        // Skip if SVG already exists
        if (Storage::disk('public')->exists($newPath)) {
            echo "Skipped: {$guest->guest_name} - SVG already exists\n";
            $skippedCount++;
            continue;
        }
        
        // Generate new SVG QR code
        $qrCodeContent = QrCode::format('svg')->size(300)->generate($guest->guest_id_qr_code);
        
        // Save SVG file
        Storage::disk('public')->put($newPath, $qrCodeContent);
        
        // Update database record
        $guest->update([
            'guest_qr_code' => 'storage/' . $newPath
        ]);
        
        echo "Converted: {$guest->guest_name} - {$oldPath} -> {$newPath}\n";
        $convertedCount++;
        
        // Optional: Delete old PNG file
        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
            echo "Deleted old PNG: {$oldPath}\n";
        }
        
    } catch (Exception $e) {
        echo "Error converting {$guest->guest_name}: " . $e->getMessage() . "\n";
        $errorCount++;
    }
}

echo "\n=== Conversion Summary ===\n";
echo "Converted: {$convertedCount} files\n";
echo "Skipped: {$skippedCount} files\n";
echo "Errors: {$errorCount} files\n";
echo "Total processed: " . ($convertedCount + $skippedCount + $errorCount) . " files\n";
echo "Conversion completed!\n";
