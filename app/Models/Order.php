<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'customer_id',
        'order_date',
        'order_status',
        // 'confirmed_at',
        'total_products',
        'sub_total',
        // 'discount',
        'discount_percent',
        'discount_rp',
        'invoice_no',
        'grandtotal',
        'payment_method',
        'shipping_status',
        'payment_status',
        'pay',
        'due',
        // 'shipping'
    ];

    public $sortable = [
        'customer_id',
        'order_date',
        'order_status',
        // 'confirmed_at',
        'total_products',
        'sub_total',
        // 'discount',
        'discount_percent',
        'discount_rp',
        'invoice_no',
        'grandtotal',
        'payment_method',
        'shipping_status',
        'payment_status',
        'pay',
        'due',
        // 'shipping'
    ];

    protected $guarded = [
        'id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
        // return $this->belongsTo(Customer::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'order_id', 'id');
    }

    public function collection()
    {
        return $this->hasMany(Collection::class, 'order_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            // Filter berdasarkan kolom dari tabel orders
            $query->where('order_date', 'like', '%' . $search . '%')
                ->orWhere('invoice_no', 'like', '%' . $search . '%')
                ->orWhere('order_status', 'like', '%' . $search . '%');

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
    }

}
