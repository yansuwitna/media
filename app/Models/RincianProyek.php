<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RincianProyek extends Model
{
    protected $table = 'rincian_proyek';

    protected $fillable = [
        'id_proyek',
        'id_lokasi_unggah',
        'nama_item',
        'jenis_media',
        'catatan',
        'status_unggah',
    ];

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'id_proyek');
    }

    public function lokasiUnggah(): BelongsTo
    {
        return $this->belongsTo(LokasiUnggah::class, 'id_lokasi_unggah');
    }
}
