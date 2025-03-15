<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publisher extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'NamaPenerbit',
        'email',
        'phone',
        'address',
        'photo',
    ];
    public $sortable = [
        'NamaPenerbit',
        'email',
        'phone',
    ];

    protected $guarded = [
        'id',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('NamaPenerbit', 'like', '%' . $search . '%');
        });
    }
}
