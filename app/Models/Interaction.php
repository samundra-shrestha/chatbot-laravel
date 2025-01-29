<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    protected $fillable = ['widget_id', 'question', 'answer'];

    public function widget(): BelongsTo
    {
        return $this->belongsTo(Widget::class);
    }
}
