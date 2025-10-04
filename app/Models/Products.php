<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'price',
        'brand',
        'model',
        'articleimage',
        'year',
    ];

    // Relationships (example: Product has many views)
    public function views()
    {
        return $this->hasMany(Viewed::class, 'product_id', 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id')->orderByDesc('position');
    }

    public function articleImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id')
            ->articles();
    }

    public function galleryImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id')
            ->galleries()
            ->orderBy('position');
    }
}
