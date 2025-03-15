<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Retur extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'delivery_id',
        'retur_date',
        'retur_status',
        'total_products',
        'sub_total',
        'discount_percent',
        'discount_rp',
        'invoice_no',
        'grandtotal',
    ];

    public $sortable = [
        'delivery_id',
        'retur_date',
        'retur_status',
        'total_products',
        'sub_total',
        'discount_percent',
        'discount_rp',
        'invoice_no',
        'grandtotal',
    ];

    protected $guarded = [
        'id',
    ];

    // protected $with = ['order'];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
                // Filter berdasarkan kolom dari tabel orders
                $query->where('retur_date', 'like', '%' . $search . '%')
                    ->orWhere('invoice_no', 'like', '%' . $search . '%')
                    ->orWhere('retur_status', 'like', '%' . $search . '%');

                    $query->orWhereHas('delivery', function ($query) use ($search) {
                        $query->wherehas('delivery_date', 'like', '%' . $search . '%')
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
                });
    }

}
