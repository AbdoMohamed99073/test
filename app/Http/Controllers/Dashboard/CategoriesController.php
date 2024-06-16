<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->query();
         
        $categories = Category::with('parent')
        /*leftJoin('categories as parents' , 'parents.id' ,'=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])*/
        //->select('categories.*')
        //->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count')
        ->withCount('products')
        ->filter($request->query())
        ->paginate();
        //$categories = $query->paginate(2);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category(); 
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules() , [
            'unique' => 'The name is already exsist !',
        ]);

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        
        $data = $request->except('logo_image');
    
       
            $data['logo_image'] = $this->UploadImage($request);
    


        $category = Category::create($data);
        
        return Redirect::route('categoriesindex')
            ->with('success', 'Caregory creatred');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show',[
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $exception) {
            return redirect()->route('categoriesindex')
                ->with('info', 'Caregory Not found');
        }
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('Parent_id')
                    ->orwhere('Parent_id', '<>', $id);
            })->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);
        $old_image = $category->logo_image;

        $data = $request->except('logo_image');
        $file = $request->file('logo_image');

        $new_image = $this->UploadImage($request);
        if($new_image){
            $data['logo_image'] = $new_image;
        }
        $category->update($data);
        if ($old_image && $new_image){
            Storage::disk('public')->delete($old_image);

        }

        return Redirect::route('categoriesindex')
            ->with('success', 'Caregory update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return redirect()->route('categoriesindex')
            ->with('success', 'Caregory archived');
    }

    protected function UploadImage(Request $request)
    {
        if (!$request->hasFile('logo_image')) {
            return;}
            $file = $request->file('logo_image');
            $extension = $file->getClientOriginalExtension();
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            return $path;
        
    }


    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request , $id)
    {
        $categories = Category::onlyTrashed()->findOrFail($id);
        $categories->restore();
        return redirect()->route('categoriestrashed')
            ->with('success', 'Caregory restored');
    }

    public function forceDelete($id)
    {
        $categories = Category::onlyTrashed()->findOrFail($id);
        
        if ($categories->logo_image){
            Storage::disk('public')->delete($categories->logo_image);
        }
        $categories->forceDelete();
        return redirect()->route('categoriestrashed')
            ->with('success', 'Caregory deleted');
    }


    public function espon()
    {
        $client = new Client();
        $res = $client->request('GET', '192.168.1.20/update?relay=2&state=1');
        //$response_data = $res->getBody()->getContents();
        
        return view('dashboard.categories.esp');
        
    }


    
    public function espoff()
    {
        $client = new Client();
        $res = $client->request('GET', '192.168.1.20/update?relay=2&state=0');
        //$response_data = $res->getBody()->getContents();
        
        return view('dashboard.categories.esp');
        
    }


}
