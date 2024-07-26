<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'Parent_id',
        'description',
        'logo_image',
        'slug',
        'status'
    ];
    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'Parent_id','id')
        ->withDefault([
            'name' =>'---',
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class,'Parent_id','id');
    }


    protected $guarded = [
        'id',
    ];
    public function scopeFilter(Builder $builder, $filter)
    {
        $builder->when($filter['name'] ?? false , function($builder , $value){
            $builder->where('categories.name' , 'LIKE' , "%{$value}%");
        });
        $builder->when($filter['stats'] ?? false , function($builder , $value){
            $builder->where('categories.status' , '=' ,$value);
        });
    }


    public function scopeActive(Builder $builder)
    {
        $builder->where('status' , '=' , 'active');
    }
    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
                //new Filter(['laravel','php','.net']),
                //'filter:laravel,php'
            ],
            'Parent_id' => [
                'nullable',
                'int',
                'exists:categories,id'
            ],
            'image' => [
                'image',
                'max:1024000000',
                'dimensions:min_width=100,min_height=100',
            ],
            'status' => 'in:active,archived',


        ];
    }

}
