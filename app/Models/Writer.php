<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Kyslik\ColumnSortable\Sortable;

class Writer extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'NamaPenulis',
        'AlamatPenulis',
        'TelpPenulis',
        'EmailPenulis',
        'CatatanPenulis',
        'writerjob_id',
        'writercategory_id',
        'FotoPenulis',
        'FotoKTP',
        'NIK',
        'NPWP',
        // 'employee_id'
    ];

    public $sortable = [
        'NamaPenulis',
        'writerjob_id',
        'writercategory_id',
        // 'employee_id'
    ];

    protected $guarded = [
        'id',
    ];

    protected $with = [
        // 'employee',
        'writerjob',
        'writercategory'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            // Filter berdasarkan kolom dari tabel orders
            $query->where('NamaPenulis', 'like', '%' . $search . '%')
                ->orWhere('AlamatPenulis', 'like', '%' . $search . '%');

                // Filter berdasarkan nama employee melalui relasi dari employee_id di customer
                $query->orWhereHas('writerjob', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });

                // Filter berdasarkan nama employee melalui relasi dari employee_id di customer
                $query->orWhereHas('writercategory', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });

                // Filter berdasarkan nama employee melalui relasi dari employee_id di customer
                // $query->orWhereHas('employee', function ($query) use ($search) {
                //     $query->where('name', 'like', '%' . $search . '%');
                // });
            });
    }
    
    // public function employee()
    // {
    //     return $this->belongsTo(Employee::class, 'employee_id', 'id');
    // }
    
    public function writerjob()
    {
        return $this->belongsTo(WriterJob::class, 'writerjob_id', 'id');
    }
    
    public function writercategory()
    {
        return $this->belongsTo(WriterCategory::class, 'writercategory_id', 'id');
    }
}
