<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'cookie_id','user_id','product_id','quantity','options'
    ];

    // Events
    // creating , created  etc...


    protected static function booted()
    {
       static::observe(CartObserver::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name' =>'anumenos'
        ]);
    }
}
