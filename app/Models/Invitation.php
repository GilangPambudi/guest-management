<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitation';

    protected $primaryKey = 'invitation_id';

    protected $fillable = [
        'wedding_name',
        'slug',
        'groom_name',
        'bride_name',
        'groom_alias',
        'bride_alias',
        'groom_image',
        'bride_image',
        'groom_child_number',
        'bride_child_number',
        'groom_father',
        'groom_mother',
        'bride_father',
        'bride_mother',
        'wedding_date',
        'wedding_time_start',
        'wedding_time_end',
        'wedding_venue',
        'wedding_location',
        'wedding_maps',
        'wedding_image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            if (empty($invitation->slug)) {
                $invitation->slug = $invitation->generateSlug($invitation->wedding_name);
            }
        });

        static::updating(function ($invitation) {
            if ($invitation->isDirty('wedding_name') && empty($invitation->slug)) {
                $invitation->slug = $invitation->generateSlug($invitation->wedding_name);
            }
        });
    }

    public function generateSlug($name)
    {
        $slug = \Illuminate\Support\Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('invitation_id', '!=', $this->invitation_id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function guests()
    {
        return $this->hasMany(Guest::class, 'invitation_id', 'invitation_id');
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class, 'invitation_id', 'invitation_id');
    }

    // Tambahkan relasi payments jika diperlukan
    public function payments()
    {
        return $this->hasMany(Payment::class, 'invitation_id', 'invitation_id');
    }
}
