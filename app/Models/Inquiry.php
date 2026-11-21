<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_no',
        'customer_name',
        'customer_phone',
        'customer_email',
        'address',
        'city',
        'state',
        'pincode',
        'assigned_to',
        'created_by',
        'source',
        'status',
        'cancel_reason',
        'subtotal',
        'coupon_id',
        'coupon_code',
        'discount_amount',
        'total_amount',
        'general_note',
        'merged_into_id',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(InquiryItem::class, 'inquiry_id');
    }

    public function notes()
    {
        return $this->hasMany(InquiryNote::class, 'inquiry_id')->orderBy('created_at', 'DESC');
    }

    public function assignedSeller()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'inquiry_id');
    }

    public function mergedInto()
    {
        return $this->belongsTo(Inquiry::class, 'merged_into_id');
    }

    /**
     * Recalculate totals from items
     */
    public function recalculateTotals()
    {
        $subtotal = $this->items()->sum('subtotal');
        $this->subtotal = $subtotal;

        $discount = 0;
        if ($this->coupon) {
            $discount = $this->coupon->calculateDiscount($subtotal);
            $this->discount_amount = $discount;
        }

        $this->total_amount = max(0, $subtotal - $discount);
        $this->save();
    }
}

