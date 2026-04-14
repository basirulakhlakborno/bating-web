<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $fillable = [
        'game_category_id',
        'title',
        'slug',
        'provider',
        'thumbnail_path',
        'href',
        'opens_in_iframe',
        'iframe_remote_base',
        'iframe_bridge_path',
        'sort_order',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'opens_in_iframe' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(GameCategory::class, 'game_category_id');
    }
}
