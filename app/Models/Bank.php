<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Bank extends Model
{
    use HasFactory, Sortable;

    protected $table = 'banks';

    protected $fillable = [
        'name',
    ];

    protected $sortable = [
        'name',
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
