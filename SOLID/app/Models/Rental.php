<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'user_id',
        'item_id',
        'start_date',
        'end_date',
        'comment'
    ];
}
