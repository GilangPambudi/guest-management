<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invitation;

class UpdateInvitationSlugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invitations = Invitation::whereNull('slug')->orWhere('slug', '')->get();
        
        foreach ($invitations as $invitation) {
            $slug = \Illuminate\Support\Str::slug($invitation->wedding_name);
            $originalSlug = $slug;
            $counter = 1;

            // Check for duplicate slugs
            while (Invitation::where('slug', $slug)->where('invitation_id', '!=', $invitation->invitation_id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $invitation->update(['slug' => $slug]);
            $this->command->info("Updated invitation '{$invitation->wedding_name}' with slug: {$slug}");
        }
        
        $this->command->info('All invitation slugs have been updated successfully!');
    }
}
