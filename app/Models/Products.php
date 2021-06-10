<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function product_category_detail(){
        return $this->hasMany(ProductCategoryDetails::class,'product_id','id');
    }
  
    public function product_image(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
  
    public function category(){
        return $this->belongsToMany(Category::class,'product_category_details', 'product_id', 'category_id')->withPivot('id');
    }
    public function Transactions(){
        return $this->belongsToMany(Transactions::class, 'transaction_details', 'product_id', 'transaction_id')->withPivot('id');
    }

    public function reviews(){
        return $this->hasMany(ReviewProducts::class,'product_id');
    }
    public function discounts(){
        return $this->hasMany(Discounts::class, 'id_product', 'id')->orderBy('id','DESC')->limit(1);
    }
}
