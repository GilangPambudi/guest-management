<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationTemplateMapping extends Model
{
    protected $fillable = [
        'invitation_id',
        'guest_category',
        'template_name'
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id', 'invitation_id');
    }
}
