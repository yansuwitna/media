<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operator extends Authenticatable
{
    use Notifiable;

    protected $table = 'operator';

    protected $fillable = [
        'nama',
        'nama_pengguna',
        'email',
        'kata_sandi',
        'id_admin_pembuat',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function daftarProyek(): HasMany
    {
        return $this->hasMany(Proyek::class, 'id_operator');
    }

    public function daftarLokasiUnggah(): HasMany
    {
        return $this->hasMany(LokasiUnggah::class, 'id_operator');
    }
}
