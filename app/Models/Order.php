<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'reference_number',
        'order_number',
        'object',
        'cargo',
        'status',
        'currency',
        'exchange_rate',
        'total',
        'vat',
        'vat_total',
        'grand_total',
        'deposit_amount',
        'deposit_description',
        'terms_conditions',
    ];

    /**
     * Get the order items for the order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['start'] ?? false,
            fn($query, $start) => $query->where('order_date', '>=', $start)
        );

        $query->when(
            $filters['end'] ?? false,
            fn($query, $end) => $query->where('order_date', '<=', $end)
        );

        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) =>
                $query->whereHas('customer', fn($q) =>
                    $q->where('name', 'like', '%' . $search . '%')
                )
        );

        $query->when(
            $filters['status'] ?? false,
            fn($query, $status) => $query->where('status', $status)
        );
    }
}
