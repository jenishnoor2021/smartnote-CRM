<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactLead extends Model
{
    use HasFactory;

    protected $table = 'contact_leads';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'book_category',
        'message',
        'source_page',
        'status',
        'notes',
    ];

    /**
     * Compatibility accessor: if subject is empty, return book_category
     */
    public function getSubjectAttribute()
    {
        return $this->attributes['subject'] ?? ($this->attributes['book_category'] ?? null);
    }
}
