<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitation';

    protected $primaryKey = 'invitation_id';

    protected $fillable = [
        'guest_id',
        'wedding_name',
        'groom_id',
        'bride_id',
        'wedding_date',
        'wedding_time_start',
        'wedding_time_end',
        'location',
        'status',
        'opened_at',
    ];

    public $timestamps = false;

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id', 'guest_id');
    }

    public function groom()
    {
        return $this->belongsTo(Couple::class, 'groom_id', 'couple_id');
    }

    public function bride()
    {
        return $this->belongsTo(Couple::class, 'bride_id', 'couple_id');
    }
}
