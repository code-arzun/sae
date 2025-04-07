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
        'department_id',
        'cashflow_code',
        'nominal',
        'notes',
        'receipt',
        'method',
        'rekening_id',
        'date',
        'created_by',
        'updated_by',
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

    protected $with = [
        // 'user',
        'createdBy',
        'updatedBy',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function cashflowcategory(){
        return $this->belongsTo(CashflowCategory::class);
    }

    public function rekening(){
        return $this->belongsTo(Rekening::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('notes', 'like', '%' . $search . '%');
        });
    }
}
