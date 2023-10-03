<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'judul',
        'banner',
        'deskripsi',
        'link',
        'active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    use SoftDeletes;
}