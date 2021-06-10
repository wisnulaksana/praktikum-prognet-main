<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    public function product(){
        return $this->belongsTo(Products::class,'product_id','id');
    }
    public function getImageAttribute()
    {
        return $this->image_name ? asset('storage/img/products_image/' . $this->image_name) : asset('assets/img/default-thumbnail.jpg');
    }
}
