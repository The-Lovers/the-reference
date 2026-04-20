<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'subject',
        'message',
        'source_type',
        'source_label',
        'contactable_type',
        'contactable_id',
    ];

    public function contactable(): MorphTo
    {
        return $this->morphTo();
    }
}
