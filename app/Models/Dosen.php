<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'user_id',
        'nidn',
        'nama_lengkap',
        'email',
        'prodi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
