<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'tipe',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'jumlah_jam',
        'alasan',
        'approved',
        'approved_by',
        'pemotongan',
        'bukti',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function userApproved()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use SoftDeletes;
}