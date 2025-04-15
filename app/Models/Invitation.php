<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitation';

    protected $primaryKey = 'invitation_id';

    protected $fillable = [
        'wedding_name',
        'groom_name',
        'bride_name',
        'groom_alias',
        'bride_alias',
        'wedding_date',
        'wedding_time_start',
        'wedding_time_end',
        'wedding_venue',
        'wedding_location',
        'wedding_maps',
        'wedding_image',
    ];

    public function guests()
    {
        return $this->hasMany(Guest::class, 'event_id', 'invitation_id');
    }
}