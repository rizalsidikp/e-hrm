<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bonus extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bonus',
        'periode',
        'deskripsi',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    use SoftDeletes;
}
