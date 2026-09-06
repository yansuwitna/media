<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyek extends Model
{
    protected $table = 'proyek';

    protected $fillable = [
        'id_operator',
        'judul_proyek',
        'deskripsi_proyek',
        'target_selesai',
        'status_proyek',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'id_operator');
    }

    public function rincian(): HasMany
    {
        return $this->hasMany(RincianProyek::class, 'id_proyek');
    }
}
