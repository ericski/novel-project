<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    public function creatorAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'event_id');
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Event $event) {
            // Recompute when creating or when the name changed or slug is empty
            if ($event->isDirty('name') || blank($event->slug)) {
                $event->slug = static::makeUniqueSlug($event->name, $event->getKey());
            }
            // Set the creator to the current user if not set
            if (blank($event->creator)) {
                $event->creator = auth()->user()->id;
            }
        });
    }

    protected static function makeUniqueSlug(string $name, $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        // Ensure uniqueness (and ignore current model on update)
        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->whereKey('id')->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
