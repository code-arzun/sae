<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ProductCategory extends Model
{
    use HasFactory, Sortable;
    
    protected $table = 'productcategories';

    protected $fillable = [
        'name',
        'productunit_id',
    ];

    protected $sortable = [
        'name',
        'productunit_id',
    ];

    protected $guarded = [
        'id',
    ];

    public function productunit()
    {
        return $this->belongsTo(ProductUnit::class, 'productunit_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
