<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'product_name',
        'product_code',
        'author_publisher',
        'medium',
        'subject',
        'standard_class',
        'mrp_price',
        'selling_price',
        'unit',
        'stock_quantity',
        'is_in_stock',
        'cover_image',
        'short_description',
        'description',
        'key_features',
        'learning_benefits',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_in_stock' => 'boolean',
        'mrp_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    /**
     * Alias for active attribute
     */
    public function getActiveAttribute()
    {
        return $this->is_active;
    }

    /**
     * Category relationship
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Subcategory relationship
     */
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    /**
     * Gallery images relationship
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order', 'ASC');
    }

    /**
     * Creator relationship
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Cover image URL helper
     */
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image && file_exists(public_path($this->cover_image))) {
            return asset($this->cover_image);
        }
        return null;
    }
}

