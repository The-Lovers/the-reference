<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
        'avatar',
        'phone',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function roles() {
        return $this->belongsToMany(Role::class);
    }
    public function hasRole(string $role): bool {
        return $this->roles()->where('name', $role)->exists();
    }
    public function testimoniesStatusUpdated(): HasMany {
        return $this->hasMany(Testimonies::class, 'status_updated_by');
    }
    public function domainsCreated(): HasMany {
        return $this->hasMany(Domains::class, 'created_by');
    }

    public function missionsCreated(): HasMany {
        return $this->hasMany(Missions::class, 'created_by');
    }
    public function localisation(): HasOne {
        return $this->hasOne(Localisation::class);
    }
    public function getGenderLabelAttribute(){
        return $this->gender == 'M' ? __('user.index.male') : __('user.index.female');
    }
    protected static function booted() {
        static::deleting(function ($user) {
            $user->roles()->detach();
        });
    }
}
