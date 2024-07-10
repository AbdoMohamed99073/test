<?php

namespace App\Models;

use App\Models\Scopes\ProductsScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
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

    public function scopeFilter(Builder $builder,$filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null ,
            'status' => 'active',

        ] , $filters);

        $builder->when($options['status'],function($quary,$status){
            return $quary->where('status',$status);
        });
        $builder->when($options['store_id'],function ($builder,$value){
            $builder->where('store_id',$value);
        });

        $builder->when($options['category_id'],function ($builder,$value){
            $builder->where('category_id',$value);
        });
        $builder->when($options['tags'],function ($builder,$value){

            $builder->whereHas('tags',function ($builder,$value){
                $builder->where('id',$value);
            });
        });

    }

}
