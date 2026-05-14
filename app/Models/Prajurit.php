<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prajurit extends Model
{
    use HasFactory;

    protected $table = 'prajurit'; 
    protected $fillable = [
        'name',
        'nrp',
        'korp',
        'gender',
        'satuan_asal',
        'satuan_baru',
        'tempat_lahir',
        'tanggal_lahir',
        'no_kep',
        'tgl_kep',
        'no_sprin',
        'tgl_sprin',
        'nik',
        'alamat',
        'pangkat',
        'angkatan', 
        'no_hp',
        'foto',
        'user_id',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
