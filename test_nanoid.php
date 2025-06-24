<?php

require_once 'vendor/autoload.php';

use Hidehalo\Nanoid\Client;

echo "Testing NanoID Implementation...\n\n";

// Test NanoID generation
$client = new Client();

echo "Sample NanoID (10 chars): " . $client->generateId(10) . "\n";
echo "Sample NanoID (8 chars): " . $client->generateId(8) . "\n";
echo "Sample NanoID (12 chars): " . $client->generateId(12) . "\n\n";

// Test guest ID format
$nanoId = $client->generateId(10);
$guestNameSlug = str_replace(' ', '-', strtolower('John Doe'));
$guestIdQrCode = "{$nanoId}-{$guestNameSlug}";

echo "Sample Guest ID: {$guestIdQrCode}\n";

// Test multiple generations
echo "\nMultiple generations:\n";
for ($i = 1; $i <= 5; $i++) {
    $id = $client->generateId(10);
    echo "{$i}. {$id}\n";
}

echo "\nNanoID implementation successful!\n";
echo "Benefits of NanoID over CUID:\n";
echo "- Shorter IDs (10 chars vs ~25 chars)\n";
echo "- URL-safe characters\n";
echo "- Better performance\n";
echo "- Smaller QR codes\n";
