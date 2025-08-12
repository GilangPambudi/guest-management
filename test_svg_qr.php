<?php

require_once 'vendor/autoload.php';

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing SVG QR Code generation...\n";

// Test data
$testId = 'test123-svg-qr';

try {
    // Generate SVG QR code
    $qrCodeContent = QrCode::format('svg')->size(300)->generate($testId);
    
    // Save to storage
    $qrCodePath = "qr/test/{$testId}.svg";
    Storage::disk('public')->put($qrCodePath, $qrCodeContent);
    
    // Check if file exists
    if (Storage::disk('public')->exists($qrCodePath)) {
        echo "✅ SVG QR Code generated successfully!\n";
        echo "📁 File saved to: storage/app/public/{$qrCodePath}\n";
        echo "🔗 Public URL: storage/{$qrCodePath}\n";
        
        // Get file size
        $fileSize = Storage::disk('public')->size($qrCodePath);
        echo "📊 File size: " . round($fileSize / 1024, 2) . " KB\n";
        
        // Show first few lines of SVG content
        $content = Storage::disk('public')->get($qrCodePath);
        $firstLine = strtok($content, "\n");
        echo "📄 SVG content starts with: {$firstLine}...\n";
        
    } else {
        echo "❌ Failed to save SVG file\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\nTest completed!\n";
