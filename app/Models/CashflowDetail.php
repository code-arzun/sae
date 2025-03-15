<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CashflowDetail extends Model
{
    use HasFactory, Sortable;

    protected $table = 'cashflowdetails';

    protected $fillable = [
        'cashflowtype_id',
        'cashflowcategory_id',
        'name',
    ];

    protected $sortable = [
        'cashflowtype_id',
        'cashflowcategory_id',
        'name',
    ];

    protected $guarded = [
        'id',
    ];

    public function cashflowtype(){
        return $this->belongsTo(CashflowType::class, 'cashflowtype_id');
    }
    
    public function cashflowcategory(){
        return $this->belongsTo(CashflowCategory::class);
        // return $this->belongsTo(CashflowCategory::class, 'cashflowcategory_id');
    }
    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    // public function getRouteKeyName()
    // {
    //     return 'type';
    // }
}
