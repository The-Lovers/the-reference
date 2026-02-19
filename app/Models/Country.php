<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'continent_id',
        'label_fr',
        'label_en',
        'code',
        'flag',
        'phone_code',
        'devise_label',
        'devise_code',
        'is_un_member',
        'is_observer',
        'is_territory'
    ];

    public function continent(){
        return $this->belongsTo(Continent::class);
    }

    public function regions(){
        return $this->hasMany(Region::class);
    }
    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }
}
