<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'network',
        'name',
        'price',
        'cost_price',
        'data_amount',
        'is_active',
        'image_path',
        'role_prices'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'role_prices' => 'array',
    ];

    protected $appends = ['image_url'];

    /**
     * Get the full URL for the product image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            // Provide high-quality network defaults
            if ($this->network) {
                $net = strtoupper($this->network);
                // Check if we have a default for this network
                return asset("storage/defaults/{$net}.png");
            }
            return null;
        }

        // If it's already a full URL, return as-is
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        // Otherwise, prepend the storage path
        return asset('storage/' . $this->image_path);
    }
}
