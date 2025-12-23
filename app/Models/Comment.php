<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'content',
        'post_id'
    ];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
