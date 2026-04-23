<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Destination extends Model
{
    use HasFactory;

     protected $fillable = [
        'label',
        'description',
        'cover',
        'country_id',
        'image_url',
        'price',
        'is_available',
        'created_by',
        'updated_by',
    ];

     public function pays()
    {
        return $this->belongsTo(Country::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relation vers le continent (via le pays)
     */
    public function continent()
    {
        return $this->belongsToThrough(Continent::class, Country::class);
    }

    protected static function booted()
    {
        static::created(function ($destination) {
            $destination->created_by = Auth::id();
            $destination->save();
        });

        static::updated(function ($destination) {
            $destination->updated_by = Auth::id();
            $destination->save();
        });
    }

    /**
     * Bascule la disponibilité de la destination.
     */
    public function toggleAvailability()
    {
        $this->is_available = !$this->is_available;
        $this->available_at = $this->is_available ? now() : null;
        $this->save();
    }
}
