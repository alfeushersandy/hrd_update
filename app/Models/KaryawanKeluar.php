<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanKeluar extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function karyawan()
    {
        return $this->belongsTo(karyawan::class, 'karyawans_id', 'id');
    }
}
