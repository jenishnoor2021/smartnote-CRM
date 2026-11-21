<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'image',
        'sort_order',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Alias for active attribute
     */
    public function getActiveAttribute()
    {
        return $this->is_active;
    }

    /**
     * Image URL helper
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        return null;
    }

    /**
     * Creator relationship
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Subcategories relationship
     */
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id')->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC');
    }

    /**
     * Products relationship
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id')->where('is_active', 1);
    }
}

