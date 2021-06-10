<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $guarded = [];

    public function products(){
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }



    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
