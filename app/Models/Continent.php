<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Continent extends Model
{
    use HasFactory;

    protected $fillable = [
        'label_fr',
        'label_en',
    ];

    public function localisations(): HasMany {
        return $this->hasMany(Localisation::class);
    }

    public function countries(): HasMany {
        return $this->hasMany(Country::class);
    }

    public function destinations()
    {
        return $this->hasManyThrough(Destination::class, Country::class);
    }
}
