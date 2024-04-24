<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'object'
    ];


}
