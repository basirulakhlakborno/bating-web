<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationItem extends Model
{
    protected $fillable = [
        'placement',
        'parent_id',
        'label_bn',
        'label_en',
        'href',
        'icon_path',
        'sort_order',
        'is_active',
        'show_underline',
        'badge_label',
        'badge_variant',
        'label_class',
        'has_badge_ui',
        'is_external',
        'drawer_meta',
        'drawer_group',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'show_underline' => 'boolean',
            'has_badge_ui' => 'boolean',
            'is_external' => 'boolean',
            'drawer_meta' => 'array',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function scopePlacement($query, string $placement)
    {
        return $query->where('placement', $placement)->whereNull('parent_id');
    }
}
