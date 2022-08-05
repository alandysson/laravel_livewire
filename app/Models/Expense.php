<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use DateTime;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'description','type','amount',
        'photo', 'expense_date'
    ];
    
    protected $dates = ['expense_date'];

    public function getAumontAttribute($prop){
        return $this->attributes['amount'] / 100;
    }

    public function setExpenseDateAttribute($prop){
        return $this->attributes['expense_date'] = (DateTime::createFromFormat('d/m/Y H:i:s', $prop))->format('Y-m-d H:i:s');
    }
    public function setAumontAttribute($prop){
        return $this->attributes['amount'] = $prop * 100;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
