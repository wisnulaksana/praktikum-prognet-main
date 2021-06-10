<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $guarded = ['harga_diskon'];

    public function TransactionDetails(){
        return $this->hasMany(TransactionDetails::class,'transaction_id');
    }

    public function product(){
        return $this->belongsToMany(Products::class, 'transaction_details', 'transaction_id', 'product_id')->withPivot('id');
    }

    public function courier(){
        return $this->belongsTo(Couriers::class, 'courier_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getImageAttribute()
    {
        return $this->proof_of_payment ? asset('storage/' . $this->proof_of_payment) : asset('assets/img/default-thumbnail.jpg');
    }
}
