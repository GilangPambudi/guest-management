<?php

require_once 'vendor/autoload.php';

use App\Models\Guest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== QR Code PNG to SVG Migration (Production) ===\n";
echo "Starting conversion...\n";

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
            echo "SKIP: {$guest->guest_name} - SVG already exists\n";
            $skippedCount++;
            continue;
        }
        
        // Check if old PNG exists
        if (!Storage::disk('public')->exists($oldPath)) {
            echo "WARN: {$guest->guest_name} - Old PNG not found, regenerating...\n";
        }
        
        // Generate new SVG QR code
        $qrCodeContent = QrCode::format('svg')->size(300)->generate($guest->guest_id_qr_code);
        
        // Save SVG file
        Storage::disk('public')->put($newPath, $qrCodeContent);
        
        // Update database record
        $guest->update([
            'guest_qr_code' => 'storage/' . $newPath
        ]);
        
        echo "CONV: {$guest->guest_name} -> {$newPath}\n";
        $convertedCount++;
        
        // Keep old PNG for safety (don't delete in production initially)
        // You can delete later after confirming everything works
        
    } catch (Exception $e) {
        echo "ERROR: {$guest->guest_name} - " . $e->getMessage() . "\n";
        $errorCount++;
    }
}

echo "\n=== PRODUCTION MIGRATION SUMMARY ===\n";
echo "Converted: {$convertedCount} files\n";
echo "Skipped: {$skippedCount} files\n";
echo "Errors: {$errorCount} files\n";
echo "Total: " . ($convertedCount + $skippedCount + $errorCount) . " guests\n";

if ($errorCount > 0) {
    echo "\n⚠️  WARNINGS: {$errorCount} errors occurred. Check logs above.\n";
} else {
    echo "\n✅ Migration completed successfully!\n";
}

echo "\nNext steps:\n";
echo "1. Test QR codes on website\n";
echo "2. Test QR scanner functionality\n";
echo "3. Monitor for 24-48 hours\n";
echo "4. If all good, clean up old PNG files\n";
echo "\nMigration completed on: " . date('Y-m-d H:i:s') . "\n";
