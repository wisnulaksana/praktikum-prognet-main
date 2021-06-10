<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $table = 'response';
    protected $guarded = [];

    public function admin(){
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
