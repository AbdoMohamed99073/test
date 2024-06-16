<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id','frist_name','last_name','birthday','gender','street_address','city',
        'state','pstal_code','country','local'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


}
