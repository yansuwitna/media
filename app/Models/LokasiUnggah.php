<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LokasiUnggah extends Model
{
    protected $table = 'lokasi_unggah';

    protected $fillable = [
        'id_operator',
        'nama_kanal',
        'tautan',
        'keterangan',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'id_operator');
    }

    public function rincian()
    {
        return $this->hasMany(RincianProyek::class, 'id_lokasi_unggah');
    }
}
