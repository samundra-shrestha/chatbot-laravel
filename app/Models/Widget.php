<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Widget extends Model
{
    protected $fillable = ['team_id', 'unique_key', 'iframe_code'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }
}
