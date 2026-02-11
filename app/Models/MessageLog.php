<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk memberikan izin pengisian kolom
    protected $fillable = [
        'recipient_phone',
        'message_type',
        'content',
        'status',
        'response_gateway',
    ];
}
