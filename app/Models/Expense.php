<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'description','type','amount'];
    
    public function getAumontAttribute($prop){
        return $this->attributes['amount'] / 100;
    }
    public function setAumontAttribute($prop){
        return $this->attributes['amount'] = $prop * 100;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}