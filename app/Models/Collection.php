<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Collection extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'order_id',
        'payment_date',
        'payment_status',
        'payment_method',
        'bank_id',
        'no_rek',
        'rekening_id',
        'paid_by',
        'employee_id',
        'invoice_no',
        'pay',
        'discount_percent',
        'discount_rp',
        'PPh22_percent',
        'PPh22_rp',
        'PPN_percent',
        'PPN_rp',
        'admin_fee',
        // 'shipping_cost',
        'other_fee',
        'invoice_no',
        'grandtotal',
        'due',
    ];

    public $sortable = [
        'order_id',
        'payment_date',
        'payment_status',
        'payment_method',
        'bank_id',
        'no_rek',
        'rekening_id',
        'paid_by',
        'employee_id',
        'invoice_no',
        'pay',
        'discount_percent',
        'discount_rp',
        'PPh22_percent',
        'PPh22_rp',
        'PPN_percent',
        'PPN_rp',
        'admin_fee',
        // 'shipping_cost',
        'other_fee',
        'invoice_no',
        'grandtotal',
        'due',
    ];

    protected $guarded = [
        'id',
    ];

    // protected $with = ['order'];

    public function salesorder()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('payment_date', 'like', '%' . $search . '%')
                ->orWhere('invoice_no', 'like', '%' . $search . '%')
                ->orWhere('payment_status', 'like', '%' . $search . '%');

            $query->orWhereHas('salesorder', function ($query) use ($search) {
                $query->where('order_date', 'like', '%' . $search . '%')
                    ->orWhere('invoice_no', 'like', '%' . $search . '%');
                
                $query->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('NamaCustomer', 'like', '%' . $search . '%')
                        ->orWhere('NamaLembaga', 'like', '%' . $search . '%');
                    
                    $query->orWhereHas('employee', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
                });
            });
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id', 'id');
    }
}
