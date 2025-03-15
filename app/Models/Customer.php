<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Kyslik\ColumnSortable\Sortable;

class Customer extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'NamaLembaga',
        'AlamatLembaga',
        'TelpLembaga',
        'EmailLembaga',
        'Potensi',
        'CatatanLembaga',
        'NamaCustomer',
        'Jabatan',
        'AlamatCustomer',
        'TelpCustomer',
        'EmailCustomer',
        'CatatanCustomer',
        'FotoCustomer',
        'FotoKTP',
        'employee_id',
    ];
    
    public $sortable = [
        'NamaLembaga',
        'NamaCustomer',
        'Jabatan',
        'employee_id',
    ];

    protected $guarded = [
        'id',
    ];

    protected $with = [
        'employee',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            // Filter berdasarkan kolom dari tabel orders
            $query->where('NamaLembaga', 'like', '%' . $search . '%')
                ->orWhere('NamaCustomer', 'like', '%' . $search . '%')
                ->orWhere('Jabatan', 'like', '%' . $search . '%')
                ->orWhere('Potensi', 'like', '%' . $search . '%');

                // Filter berdasarkan nama employee melalui relasi dari employee_id di customer
                $query->orWhereHas('employee', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            });
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
