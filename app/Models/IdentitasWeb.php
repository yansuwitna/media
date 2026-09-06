<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentitasWeb extends Model
{
    protected $table = 'identitas_web';

    protected $fillable = [
        'nama_aplikasi',
        'deskripsi_aplikasi',
        'jalur_logo',
        'teks_footer',
        'tema_bawaan',
    ];
}
