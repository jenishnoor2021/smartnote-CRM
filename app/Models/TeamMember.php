<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $table = 'team_members';

    protected $fillable = [
        'name',
        'designation',
        'image',
        'quote',
        'bio',
        'phone',
        'email',
        'facebook',
        'linkedin',
        'twitter',
        'instagram',
        'is_leadership',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_leadership' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Compatibility accessor for linkedin_url
     */
    public function getLinkedinUrlAttribute()
    {
        return $this->attributes['linkedin'] ?? null;
    }

    /**
     * Compatibility mutator for linkedin_url
     */
    public function setLinkedinUrlAttribute($value)
    {
        $this->attributes['linkedin'] = $value;
    }
}
