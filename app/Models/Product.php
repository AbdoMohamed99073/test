<?php

namespace App\Models;

use App\Models\Scopes\ProductsScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    protected static function booted()
    {
        static::addGlobalScope(ProductsScope::class);
    }


    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',  
            'product_id',   
            'tag_id', 
            'id',
            'id',
        );
    }
}
