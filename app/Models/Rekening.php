<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Rekening extends Model
{
    use HasFactory, Sortable;

    protected $table = 'rekenings';

    protected $fillable = [
        'bank_id',
        'no_rek',
        'nama',
    ];

    protected $sortable = [
        'banks_id',
        'no_rek',
        'nama',
    ];

    protected $guarded = [
        'id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        });
    }

}
