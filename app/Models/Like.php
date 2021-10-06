<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id', 
    ];

    protected $table = 'likeable' ;     

    public function likeable(){
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo('App\Models\User'); 
   } 

}
