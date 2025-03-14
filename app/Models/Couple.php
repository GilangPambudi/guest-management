<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couple extends Model
{
    protected $table = 'couple';

    protected $primaryKey = 'couple_id';

    protected $fillable = [
        'couple_name',
        'couple_alias',
        'couple_gender',
    ];
}