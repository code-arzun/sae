<?php

namespace App\Models;

use App\Models\CashflowCategory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashflow extends Model
{
    use HasFactory, Sortable;

    protected $table = 'cashflows';
    
    protected $fillable = [
        'cashflowcategory_id',
        'user_id',
        'department_id',
        'cashflow_code',
        'nominal',
        'notes',
        'receipt',
        'date',
    ];

    public $sortable = [
        'cashflowcategory_id',
        'user_id',
        'department_id',
        'cashflow_code',
        'nominal',
        'notes',
        'date',
    ];

    protected $guarded = [
        'id',
    ];

    public function user(){
        // return $this->belongsTo(User::class, 'user_id');
        return $this->belongsTo(User::class, 'id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function cashflowcategory(){
        return $this->belongsTo(cashflowcategory::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('notes', 'like', '%' . $search . '%');
        });
    }
}
