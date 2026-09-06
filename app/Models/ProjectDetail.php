<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDetail extends Model
{
    protected $fillable = [
        'project_id',
        'upload_location_id',
        'item_name',
        'media_type',
        'notes',
        'status',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function uploadLocation(): BelongsTo
    {
        return $this->belongsTo(UploadLocation::class, 'upload_location_id');
    }
}
