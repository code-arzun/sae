<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Delivery extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'order_id',
        // 'customer_id',
        'delivery_date',
        'delivery_status',
        'total_products',
        'sub_total',
        'invoice_no',
        'packed_at',
        'sent_at',
        'delivered_at',
        
    ];

    public $sortable = [
        'order_id',
        // 'customer_id',
        'delivery_date',
        'sub_total',
        'packed_at',
        'sent_at',
        'delivered_at',
    ];

    protected $guarded = [
        'id',
    ];

    // protected $with = ['order'];

    public function salesorder()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // 1st method
    protected $appends = ['delivery_order'];

    public function getDeliveryOrderAttribute()
    {
        return self::where('order_id', $this->order_id)
            ->where('created_at', '<=', $this->created_at)
            ->count();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            // Filter berdasarkan kolom dari tabel orders
            $query->where('delivery_date', 'like', '%' . $search . '%')
                ->orWhere('invoice_no', 'like', '%' . $search . '%')
                ->orWhere('delivery_status', 'like', '%' . $search . '%');

            // Filter berdasarkan relasi ke tabel salesorder
            $query->orWhereHas('salesorder', function ($query) use ($search) {
                $query->where('order_date', 'like', '%' . $search . '%')
                    ->orWhere('invoice_no', 'like', '%' . $search . '%');
                
                // Filter berdasarkan relasi ke tabel customers
                $query->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('NamaCustomer', 'like', '%' . $search . '%')
                        ->orWhere('NamaLembaga', 'like', '%' . $search . '%');
                    
                    // Filter berdasarkan nama employee melalui relasi dari employee_id di customer
                    $query->orWhereHas('employee', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
                });
            });
        });
    }

    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class, 'customer_id', 'id');
    // }
}
