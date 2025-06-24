<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

echo "Checking invitation and guests...\n";

$invitation = App\Models\Invitation::first();
if ($invitation) {
    echo "Invitation: {$invitation->wedding_name} (slug: {$invitation->slug})\n";
    
    $guest = App\Models\Guest::where('invitation_id', $invitation->invitation_id)->first();
    if ($guest) {
        echo "Sample URL: /invitation-letter/{$invitation->slug}/{$guest->guest_id_qr_code}\n";
        echo "Full URL: http://localhost/invitation-letter/{$invitation->slug}/{$guest->guest_id_qr_code}\n";
    } else {
        echo "No guests found for this invitation\n";
    }
} else {
    echo "No invitations found\n";
}
