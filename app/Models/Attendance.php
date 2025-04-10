<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Attendance extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'employee_id',
        'status',
        // 'datang',
        'pulang',
        'keterangan',
        'work_journal',
        
    ];

    public $sortable = [
        'employee_id',
        'status',
        // 'datang',
        // 'pulang',
        'keterangan',
        'work_journal',
    ];

    // protected $casts = [
    //     'datang' => 'date:H:i',
    //     'pulang' => 'date:H:i',
    // ];
    
    protected $guarded = [
        'id'
    ];

    protected $with = [
        'employee',
        'user'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }


    public function getRouteKeyName()
    {
        return 'employee_id';
    }
    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('employee_id', 'like', '%' . $search . '%');
        });
    }
}
