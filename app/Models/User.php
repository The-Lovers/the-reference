<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
        'code',
        'phone',
        'gender',
        'force_password_change',
        'password_changed_at',
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
        'force_password_change' => 'boolean',
        'password_changed_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string $role): bool {
        return $this->roles()->where('name', $role)->exists();
    }

    public function primaryRoleName(): ?string
    {
        $hierarchy = [
            'super-admin' => 3,
            'admin' => 2,
            'user' => 1,
        ];

        return $this->roles
            ->sortByDesc(fn ($role) => $hierarchy[$role->name] ?? 0)
            ->pluck('name')
            ->first();
    }

    public function highestRoleLevel(): int
    {
        $hierarchy = [
            'super-admin' => 3,
            'admin' => 2,
            'user' => 1,
        ];

        return (int) $this->roles
            ->map(fn ($role) => $hierarchy[$role->name] ?? 0)
            ->max();
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

    public function servicesCreated(): HasMany
    {
        return $this->hasMany(Services::class, 'created_by');
    }

    public function destinationsCreated(): HasMany
    {
        return $this->hasMany(Destination::class, 'created_by');
    }

    public function localisation(): HasOne {
        return $this->hasOne(Localisation::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(DirectMessage::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(DirectMessage::class, 'recipient_id');
    }

    public function getGenderLabelAttribute(){
        return $this->gender == 'M' ? __('user.index.male') : __('user.index.female');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . $this->surname);
    }

    public function getFullPhoneAttribute(): string
    {
        return trim(collect([$this->code, $this->phone])->filter()->implode(' '));
    }

    public function getPrimaryRoleLabelAttribute(): string
    {
        $roleName = $this->primaryRoleName();

        if (!$roleName) {
            return '-';
        }

        return __("user.roles.{$roleName}");
    }

    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->avatar)) {
            return sec_asset('images/logo.png');
        }

        if (Str::startsWith($this->avatar, ['http://', 'https://'])) {
            return $this->avatar;
        }

        $path = ltrim($this->avatar, '/');

        if (Str::startsWith($path, 'public/')) {
            $path = Str::replaceFirst('public/', '', $path);
        }

        if (Str::startsWith($path, 'storage/')) {
            return sec_asset($path);
        }

        if (Str::startsWith($path, 'avatars/')) {
            return sec_asset('storage/' . $path);
        }

        return sec_asset($path);
    }

    public function chatUnreadCount(): int
    {
        return (int) DirectMessage::query()
            ->where('recipient_id', $this->id)
            ->whereNull('read_at')
            ->count();
    }

    public function chatConversationSummaries(?int $limit = null): Collection
    {
        $unreadCounts = DirectMessage::query()
            ->selectRaw('sender_id, COUNT(*) as unread_count')
            ->where('recipient_id', $this->id)
            ->whereNull('read_at')
            ->groupBy('sender_id')
            ->pluck('unread_count', 'sender_id');

        $messages = DirectMessage::query()
            ->with([
                'sender:id,name,surname,avatar,email',
                'recipient:id,name,surname,avatar,email',
            ])
            ->where(function ($query) {
                $query->where('sender_id', $this->id)
                    ->orWhere('recipient_id', $this->id);
            })
            ->latest()
            ->get();

        $summaries = $messages
            ->unique(function (DirectMessage $message) {
                return $message->sender_id === $this->id
                    ? $message->recipient_id
                    : $message->sender_id;
            })
            ->map(function (DirectMessage $message) use ($unreadCounts) {
                $counterpart = $message->sender_id === $this->id
                    ? $message->recipient
                    : $message->sender;

                if (!$counterpart) {
                    return null;
                }

                return [
                    'user' => [
                        'id' => $counterpart->id,
                        'name' => $counterpart->full_name,
                        'email' => $counterpart->email,
                        'avatar_url' => $counterpart->avatar_url,
                    ],
                    'last_message' => Str::limit($message->body, 90),
                    'last_message_full' => $message->body,
                    'last_message_at' => $message->created_at?->diffForHumans(),
                    'last_message_at_iso' => $message->created_at?->toIso8601String(),
                    'is_from_me' => $message->sender_id === $this->id,
                    'unread_count' => (int) ($unreadCounts[$counterpart->id] ?? 0),
                ];
            })
            ->filter()
            ->values();

        return $limit ? $summaries->take($limit)->values() : $summaries;
    }

    protected static function booted() {
        static::deleting(function ($user) {
            $user->roles()->detach();
        });
    }
}
