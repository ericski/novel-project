<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BannedWord extends Model
{
    use HasFactory;

    public function added_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
