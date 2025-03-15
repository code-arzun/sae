<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'product_name',
        'slug',
        'category_id',
        'publisher_id',
        'writer_id',
        'cover',
        'isbn1',
        'isbn2',
        'isbn3',
        'isbn4',
        'isbn5',
        'published',
        'page',
        'weight',
        'length',
        'width',
        'thickness',
        'description',
        'product_code',
        'product_image',
        'product_store',
        'product_ordered',
        'stock_needed',
        'buying_date',
        'expire_date',
        'buying_price',
        'selling_price',
    ];

    public $sortable = [
        'product_name',
        'category_id',
        'publisher_id',
        'writer_id',
        'product_code',
        'product_image',
        'product_store',
        'product_ordered',
        'stock_needed',
        'buying_date',
        'expire_date',
        'buying_price',
        'selling_price',
    ];

    protected $guarded = [
        'id',
    ];

    protected $with = [
        'category',
        'publisher',
        'writer'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        // Cek apakah slug null atau tidak
        if ($field === null) {
            $field = 'slug';
        }

        // Coba temukan berdasarkan slug terlebih dahulu
        $model = $this->where($field, $value)->first();

        // Jika tidak ditemukan, coba temukan berdasarkan id
        if (!$model && $field === 'slug') {
            $model = $this->where('id', $value)->first();
        }

        return $model;
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function writer()
    {
        return $this->belongsTo(Writer::class, 'writer_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('product_name', 'like', '%' . $search . '%');
        });
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'product_id');
        // return $this->hasMany(OrderDetails::class, 'product_id', 'id');
    }

    public function deliveryDetails()
    {
        return $this->hasMany(DeliveryDetails::class, 'product_id', 'id');
    }

    public function returDetails()
    {
        return $this->hasMany(ReturDetails::class, 'product_id', 'id');
    }

}
