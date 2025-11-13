<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    // always load with the author
    protected $with = ['author'];

    protected $casts = [
        'active' => 'boolean',
        'goal_type' => 'boolean',
    ];

    /**
     * When the avatar is updated, clear any flags and set "censored" to false.
     */
    public function setCoverAttribute($value): void
    {
        $this->attributes['cover'] = $value;
        $this->flags()->delete();
        $this->censored = false;
    }

    public function getFlagsCountAttribute(): int
    {
        return $this->flags->count();
    }

    public function getTypeAttribute(): string
    {
        return $this->goal_type ? 'words' : 'days';
    }

    public function getProgressAttribute(): float
    {
        // Return the stored percent_complete value if it exists, otherwise calculate it
        return $this->percent_complete ?? ($this->goal > 0 ? ($this->updates->sum('count') / $this->goal * 100) : 0);
    }

    public function getCompletedAttribute(): int
    {
        return $this->updates->sum('count');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function updates(): HasMany
    {
        return $this->hasMany(ProjectUpdate::class)->orderBy('date');
    }

    public function latestUpdates(): HasMany
    {
        return $this->hasMany(ProjectUpdate::class)->orderBy('date', 'DESC');
    }

    public function flags(): MorphMany
    {
        return $this->morphMany(Flag::class, 'flaggable');
    }

    public function scopeMine($query)
    {
        return $query->where('author_id', auth()->id());
    }

    public function scopeFriends()
    {
        // Get the projects of the friends of the current user where "friends" are defined as someone the user is following
        return $this->whereHas('author.followers', function ($query) {
            $query->where('follower_id', auth()->id());
        });
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $potential_slug = Str::slug($value);
        //check that the slug is unique
        $slug = $potential_slug;
        $i = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = $potential_slug . '-' . $i++;
        }
        $this->attributes['slug'] = Str::slug($slug);
    }

    public function getChartData($type = 'overall'): array
    {
        $data = [
            'labels' => [],
            'progress' => [],
        ];
        $running_total = 0;
        foreach ($this->updates as $update) {
            $running_total += $update->count;
            $data['labels'][] = $update->date->format('Y-m-d');
            $data['progress'][] = $type == 'daily' ? $update->count : $running_total;
        }
        return $data;
    }

}
