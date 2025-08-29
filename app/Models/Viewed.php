<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viewed extends Model
{
    use HasFactory;

    protected $table = 'vieweds';

    protected $fillable = [
        'product_id',
        'ip_address',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'product_id');
    }
}
