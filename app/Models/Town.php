<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'label_fr',
        'label_en',
    ];

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function zones(){
        return $this->hasMany(Zone::class);
    }
}
