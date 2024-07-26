<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return Product::filter($request->query())
            ->with('category:id,name', 'store:id,name', 'tags:id,name')
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Product::rules() , [
            'unique' => 'The name is already exsist !',
        ]);


       /* $val = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:255',
            'status' => 'in:active,archived',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0|gt:price',
        ]);*/
        $product = Product::create($request->all());

        return response()->json($product , 201) ;


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $product->load('category:id,name', 'store:id,name', 'tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'description' => 'nullable|string|max:255',
            'status' => 'in:active,archived',
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0|gt:price',
        ]);
        $product->update($request->all());

        return response()->json($product) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);

        return response()->json([
            'message' => 'Product Deleted',
        ] , 200);
    }
}
