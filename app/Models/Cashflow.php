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
        'method',
        'employee_id',
        'rekening_id',
        'bank_id',
        'rekeningPartner',
        'namaPartner',
        'date',
        'receipt',
        'created_by',
        'updated_by',
    ];

    public $sortable = [
    ];

    protected $guarded = [
        'id',
    ];

    protected $with = [
        // 'user',
        'createdBy',
        'updatedBy',
        // 'rekeningPerusahaan',
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

    public function rekeningPerusahaan(){
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }
    
    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('notes', 'like', '%' . $search . '%');
        });
    }
}
