<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Stock extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'supplier_id',
        'stock_date',
        // 'stock_status',
        'total_products',
        'sub_total',
        // 'discount',
        'invoice_no',
        // 'grandtotal',
        // 'payment_status',
    ];

    public $sortable = [
        'supplier_id',
        'stock_date',
        // 'stock_status',
        'total_products',
        'sub_total',
        // 'discount',
        'invoice_no',
        // 'grandtotal',
        // 'payment_status',
    ];

    protected $guarded = [
        'id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('invoice_no', 'like', '%' . $search . '%');
        });
    }
}
