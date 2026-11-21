<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';

    protected $fillable = [
        'name',
        'designation',
        'institution',
        'school_name',
        'avatar',
        'image',
        'rating',
        'review',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * School name / Institution bidirectional compatibility
     */
    public function getSchoolNameAttribute()
    {
        return $this->attributes['school_name'] ?? ($this->attributes['institution'] ?? null);
    }

    public function setSchoolNameAttribute($value)
    {
        $this->attributes['school_name'] = $value;
        $this->attributes['institution'] = $value;
    }

    public function getInstitutionAttribute()
    {
        return $this->attributes['institution'] ?? ($this->attributes['school_name'] ?? null);
    }

    public function setInstitutionAttribute($value)
    {
        $this->attributes['institution'] = $value;
        $this->attributes['school_name'] = $value;
    }

    /**
     * Image / Avatar bidirectional compatibility
     */
    public function getImageAttribute()
    {
        return $this->attributes['image'] ?? ($this->attributes['avatar'] ?? null);
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $value;
        $this->attributes['avatar'] = $value;
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ?? ($this->attributes['image'] ?? null);
    }

    public function setAvatarAttribute($value)
    {
        $this->attributes['avatar'] = $value;
        $this->attributes['image'] = $value;
    }

    public function getImageUrlAttribute()
    {
        $img = $this->image ?? $this->avatar;
        return $img ? asset($img) : null;
    }
}
