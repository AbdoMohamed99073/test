<?php

namespace App\Models;

use App\Models\Scopes\ProductsScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' , 'description' ,'price' , 'compare_price' , 'category_id' , 'store_id' ,'slug' ,
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'image',
        'slug'
    ];
    protected $appends = [
        'image_url'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    protected static function booted()
    {
        static::addGlobalScope(ProductsScope::class);

        static::creating(function(Product $product)
        {
            $product->slug = Str::slug($product->name);
        });
    }


    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
        );
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',

        ], $filters);

        $builder->when($options['status'], function ($quary, $status) {
            return $quary->where('status', $status);
        });
        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {

            $builder->whereHas('tags', function ($builder, $value) {
                $builder->where('id', $value);
            });


            /*       $builder->whereRow('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)' , [$value]);

                    // Best Performance
                    $builder->whereRow(' EXIXTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)',[$value]);

                    $builder->whereExists(function($quary) use ($value)
                    {
                        $quary->select(1)
                            ->from('product_tag')
                            ->whereRow('product_id = products.id')
                            ->where('tag_id' , $value);
                    });
            */
        });

    }


    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.google.com/imgres?q=default%20image%20product&imgurl=https%3A%2F%2Fcurie.pnnl.gov%2Fsites%2Fdefault%2Ffiles%2Fdefault_images%2Fdefault-image_0.jpeg&imgrefurl=https%3A%2F%2Fcurie.pnnl.gov%2Findex.php%2Ftaxonomy%2Fterm%2F267&docid=T6snBwoI1gW1oM&tbnid=6tO2K22XfMJMrM&vet=12ahUKEwj9jpikpsKHAxUPfKQEHUX1AuoQM3oECH8QAA..i&w=500&h=500&hcb=2&ved=2ahUKEwj9jpikpsKHAxUPfKQEHUX1AuoQM3oECH8QAA';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($id),

            ],
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'description' => [
                'nullable',
                'string',
                'max:255',
            ],
            'status' => [
                'in:active,archived',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'compare_price' => [
                'nullable',
                'numeric',
                'min:0',
                'gt:price'
            ],
            'store_id' => [
                'required',
                'exists:stores,id'
            ],
        ];
    }
}

/*
$request->validate([
    'name' => 'required|string|max:255',
    'category_id' => 'required|exists:categories,id',
    'description' => 'nullable|string|max:255',
    'status' => 'in:active,archived',
    'price' => 'required|numeric|min:0',
    'compare_price' => 'nallable|numeric|min:0|gt:price',
]);
*/
