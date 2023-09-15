<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tanggal',
        'shift',
        'jam_mulai',
        'jam_selesai',
        'jumlah_jam',
        'approved_user',
        'approved_pengawas',
        'approved_manajer',
        'pengawas_id',
        'manajer_id',
        'jumlah_operator',
        'alasan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengawas()
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function manajer()
    {
        return $this->belongsTo(User::class, 'manajer_id');
    }
}