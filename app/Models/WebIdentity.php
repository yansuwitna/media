<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebIdentity extends Model
{
    protected $fillable = [
        'app_name',
        'app_description',
        'logo_path',
        'footer_text',
        'theme_default',
    ];
}
