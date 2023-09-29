<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tipe_pelatihan',
        'nama',
        'deskripsi',
        'file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    use SoftDeletes;
}
