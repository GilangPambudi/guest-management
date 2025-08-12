<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test 1: Check existing guests and categories
echo "=== Existing Guests and Categories ===" . PHP_EOL;
$guests = \App\Models\Guest::all();
foreach ($guests as $guest) {
    echo "- {$guest->guest_name} (Category: {$guest->guest_category})" . PHP_EOL;
}

// Test 2: Create sample template mapping
echo PHP_EOL . "=== Creating Template Mapping ===" . PHP_EOL;
$invitation = \App\Models\Invitation::first();
if ($invitation) {
    echo "Working with invitation: {$invitation->wedding_name}" . PHP_EOL;
    
    // Create mapping: VIP -> invitation_2
    if ($guests->where('guest_category', 'VIP')->count() > 0) {
        $mapping = \App\Models\InvitationTemplateMapping::updateOrCreate(
            [
                'invitation_id' => $invitation->invitation_id,
                'guest_category' => 'VIP'
            ],
            [
                'template_name' => 'invitation_2'
            ]
        );
        echo "✓ VIP category mapped to invitation_2" . PHP_EOL;
    }
    
    // Create mapping: Regular -> invitation_1
    if ($guests->where('guest_category', 'Regular')->count() > 0) {
        $mapping = \App\Models\InvitationTemplateMapping::updateOrCreate(
            [
                'invitation_id' => $invitation->invitation_id,
                'guest_category' => 'Regular'
            ],
            [
                'template_name' => 'invitation_1'
            ]
        );
        echo "✓ Regular category mapped to invitation_1" . PHP_EOL;
    }
}

// Test 3: Check template mappings
echo PHP_EOL . "=== Current Template Mappings ===" . PHP_EOL;
$mappings = \App\Models\InvitationTemplateMapping::all();
foreach ($mappings as $mapping) {
    echo "- {$mapping->guest_category} -> {$mapping->template_name}" . PHP_EOL;
}

echo PHP_EOL . "✓ Template mapping test completed!" . PHP_EOL;
