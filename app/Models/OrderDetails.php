<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unitcost',
        'total',
        'to_send',
        'ready_to_send',
        'sent',
        'delivered',
    ];

    protected $sortable = [
        'order_id',
        'product_id',
        'quantity',
        'unitcost',
        'total',
        'to_send',
        'ready_to_send',
        'sent',
        'delivered',
    ];

    protected $guarded = [
        'id',
    ];
    
    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('product_name', 'like', '%' . $search . '%');
        });
    }
}
