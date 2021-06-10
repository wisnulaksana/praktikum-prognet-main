<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProducts extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $guarded = [];

    public function Product(){
        return $this->belongsTo(Products::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function response(){
        return $this->hasMany(Response::class, 'review_id', 'id');
    }
}
