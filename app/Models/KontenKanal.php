<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontenKanal extends Model
{
    protected $table = 'konten_kanal';

    protected $fillable = [
        'id_rincian_proyek',
        'id_lokasi_unggah',
        'link_unggahan',
    ];

    public function rincianProyek(): BelongsTo
    {
        return $this->belongsTo(RincianProyek::class, 'id_rincian_proyek');
    }

    public function lokasiUnggah(): BelongsTo
    {
        return $this->belongsTo(LokasiUnggah::class, 'id_lokasi_unggah');
    }
}
