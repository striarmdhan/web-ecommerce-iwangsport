<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'color',
        'stock',
    ];

    protected $casts = [
        'stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getVariantLabelAttribute(): string
    {
        $parts = [];
        if ($this->size) {
            $parts[] = $this->size;
        }
        if ($this->color) {
            $parts[] = $this->color;
        }
        return implode(' - ', $parts);
    }
}
