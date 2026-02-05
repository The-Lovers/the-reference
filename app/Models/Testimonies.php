<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonies extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'note',
        'message',
        'description',
        'status',
        'avatar',
        'status_updated_by',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function statusUpdatedBy(): BelongsTo {
        return $this->belongsTo(User::class, 'status_updated_by');
    }
}
