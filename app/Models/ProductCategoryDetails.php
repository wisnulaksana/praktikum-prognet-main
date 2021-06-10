<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryDetails extends Model
{
    use HasFactory;
    protected $table = 'product_category_details';
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Products::class,'product_id','id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
