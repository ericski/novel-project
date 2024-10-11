<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Nova\Actions\Actionable;

class DiscordInvite extends Model
{
    use HasFactory, Actionable;

    protected $guarded = [];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
