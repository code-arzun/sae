<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CashflowCategory extends Model
{
    use HasFactory, Sortable;

    protected $table = 'cashflowcategories';

    protected $fillable = [
        'type',
        'category',
        'detail',
    ];

    protected $sortable = [
        'type',
        'category',
        'detail',
    ];

    protected $guarded = [
        'id',
    ];

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
