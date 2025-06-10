<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'pickup_date',
        'pickup_time_slot',
        'pickup_address',
        'pickup_instructions',
        'delivery_date',
        'delivery_time_slot',
        'delivery_address',
        'delivery_instructions',
        'services',
        'subtotal',
        'tax_amount',
        'delivery_fee',
        'total_amount',
        'payment_status',
        'payment_method',
        'payment_transaction_id',
        'scheduled_at',
        'picked_up_at',
        'processing_started_at',
        'ready_at',
        'delivered_at',
        'special_instructions',
        'estimated_items_count',
        'notes',
    ];

    protected $casts = [
        'services' => 'array',
        'pickup_date' => 'date',
        'delivery_date' => 'date',
        'scheduled_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'processing_started_at' => 'datetime',
        'ready_at' => 'datetime',
        'delivered_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'pickup_scheduled' => 'Pickup Scheduled',
            'picked_up' => 'Picked Up',
            'processing' => 'Processing',
            'ready' => 'Ready for Delivery',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'pickup_scheduled' => 'info',
            'picked_up' => 'primary',
            'processing' => 'primary',
            'ready' => 'success',
            'out_for_delivery' => 'success',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Methods
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'LC-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    public function updateStatus($status, $timestamp = null)
    {
        $this->status = $status;
        
        switch($status) {
            case 'pickup_scheduled':
                $this->scheduled_at = $timestamp ?? now();
                break;
            case 'picked_up':
                $this->picked_up_at = $timestamp ?? now();
                break;
            case 'processing':
                $this->processing_started_at = $timestamp ?? now();
                break;
            case 'ready':
                $this->ready_at = $timestamp ?? now();
                break;
            case 'delivered':
                $this->delivered_at = $timestamp ?? now();
                break;
        }
        
        $this->save();
    }
}