<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pengirim',
        'id_penerima',
        'pesan',
        'pesan_saya',
        'image'
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'id_pengirim', 'id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'id_penerima', 'id');
    }

}
