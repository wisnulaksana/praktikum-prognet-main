<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;
    protected $table = 'transaction_details';
    protected $guarded = [];

    public function Transaction(){
        return $this->belongsTo(Transactions::class);
    }
    public function Product(){
        return $this->belongsTo(Products::class);
    }
}
