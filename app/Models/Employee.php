<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class Employee extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name',
        'position_id',
        'department_id',
        'email',
        'phone',
        'address',
        'experience',
        'photo',
        'salary',
        // 'vacation',
        // 'city',
    ];

    public $sortable = [
        'name',
        'position_id',
        'department_id',
        'email',
        'phone',
        'salary',
        'experience',
        'address',
        // 'city',
    ];

    protected $guarded = [
        'id'
    ];

    public function position(){
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function advance_salaries()
    {
        return $this->hasMany(AdvanceSalary::class);
    }

    // public function user()
    // {
    //     return $this->hasOne(User::class, 'employee_id');
    // }

    // public function user()
    // {
    //     return $this->hasOne(User::class, 'id', 'employee_id');
    // }

    // public function customer()
    // {
    //     return $this->hasMany(Customer::class);
    // }
    
    public function customers()
    {
        return $this->hasMany(Customer::class, 'employee_id', 'id');
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Customer::class, 'employee_id', 'customer_id', 'id', 'id');
    }
}
