<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'short_description',
        'content',
        'features',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get features as an array (from newline-separated text or JSON)
     */
    public function getFeaturesListAttribute()
    {
        if (empty($this->features)) {
            return [];
        }

        if (is_array($this->features)) {
            return $this->features;
        }

        // Try JSON decode
        $decoded = json_decode($this->features, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        // Otherwise split by newline
        $lines = preg_split('/\r\n|\r|\n/', (string)$this->features);
        return array_values(array_filter(array_map('trim', $lines)));
    }
}
