<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $guarded = [];
    public function product_category_detail(){
        return $this->hasMany(ProductCategoryDetails::class,'category_id','id');
    }

    public function product(){
        return $this->belongsToMany(Products::class,'product_category_details','category_id', 'product_id')->withPivot('id');
    }
}
