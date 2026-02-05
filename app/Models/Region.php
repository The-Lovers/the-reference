<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'label_fr',
        'label_en',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function towns(){
        return $this->hasMany(Town::class);
    }
}
