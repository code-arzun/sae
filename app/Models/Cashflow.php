<?php

namespace App\Models;

use App\Models\CashflowCategory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashflowExpense extends Model
{
    use HasFactory, Sortable;

    protected $table = 'cashflowexpenses';
    
    protected $fillable = [
        'cashflowcategory_id',
        'user_id',
        'department_id',
        'cashflow_code',
        'nominal',
        'notes',
        'receipt',
        'expense_code',
        'date',
    ];

    public $sortable = [
        'cashflowcategory_id',
        'user_id',
        'department_id',
        'cashflow_code',
        'nominal',
        'notes',
        'expense_code',
        'date',
    ];

    protected $guarded = [
        'id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function cashflowdetail(){
        return $this->belongsTo(CashflowDetail::class);
        // return $this->belongsTo(CashflowDetail::class, 'cashflowdetail_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('notes', 'like', '%' . $search . '%');
        });
    }
}
