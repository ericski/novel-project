<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'profile',
        'bio',
        'timezone',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * When the avatar is updated, clear any flags and set "censored" to false.
     */
    public function setAvatarAttribute($value): void
    {
        $this->attributes['avatar'] = $value;
        $this->flags()->delete();
        $this->censored = false;
    }

    // Automatically set the profile to the name slugified
    public function setProfileAttribute($value): void
    {
        $profile = Str::slug($value);
        $i = 1;
        while (User::where('profile', $profile)->exists()) {
            $profile = Str::slug($value).'-'.$i++;
        }
        $this->attributes['profile'] = $profile;
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'followed_id', 'follower_id');
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'followed_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'author_id');
    }

    public function flags(): MorphMany
    {
        return $this->morphMany(Flag::class, 'flaggable');
    }

    public function getFlagsCountAttribute(): int
    {
        return $this->flags->count();
    }

    public function currentProject(): Project|null
    {
        return $this->projects->where('active', true)->first();
    }

    public function olderProjects()
    {
        return $this->projects->where('active', false);
    }
}
