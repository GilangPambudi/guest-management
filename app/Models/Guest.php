<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'guest_name',
        'guest_id_qr_code',
        'guest_gender',
        'guest_category',
        'guest_contact',
        'guest_address',
        'guest_qr_code',
        'guest_attendance_status',
        'guest_invitation_status',
        'guest_arrival_time',
        'user_id',
        'invitation_id', // Tambahkan ini
    ];

    protected $primaryKey = 'guest_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id', 'invitation_id');
    }
}