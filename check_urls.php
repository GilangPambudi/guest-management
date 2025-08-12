<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Test URLs for Different Templates ===" . PHP_EOL;
$invitation = \App\Models\Invitation::first();
echo "Invitation slug: {$invitation->slug}" . PHP_EOL;
echo PHP_EOL;

$guests = \App\Models\Guest::all();
foreach ($guests as $guest) {
    echo "Guest: {$guest->guest_name}" . PHP_EOL;
    echo "Category: {$guest->guest_category}" . PHP_EOL;
    echo "QR Code: {$guest->guest_id_qr_code}" . PHP_EOL;
    echo "Test URL: http://localhost:8000/{$invitation->slug}/{$guest->guest_id_qr_code}" . PHP_EOL;
    echo "Expected Template: " . ($guest->guest_category === 'VIP' ? 'invitation_2 (Luxury)' : 'invitation_1 (Standard)') . PHP_EOL;
    echo "---" . PHP_EOL;
}
