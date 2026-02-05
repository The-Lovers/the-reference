<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Localisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'whatsapp',
        'facebook',
        'linkedin',
        'user_id',
        'continent_id',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function continent(): BelongsTo {
        return $this->belongsTo(Continent::class);
    }
}
