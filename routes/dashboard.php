<?php
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsControler;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Models\Profile;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'dashboard'
],function(){

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/categories/trashed',[CategoriesController::class,'trash'])->name('categoriestrashed');

    Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])->name('categoriesrestore');

    Route::delete('/categories/{category}/forcedelete',[CategoriesController::class,'forceDelete'])->name('categoriesforceDelete');

    Route::resource('/categories' , CategoriesController::class)
        ->names([
            'index' => 'categoriesindex',
            'create' => 'categoriescreate',
            'show' => 'categoriesshow',
            'store' => 'categoriesstore',
            'edit' => 'categoriesedit',
            'update' => 'categoriesupdate',
            'destroy' => 'categoriesdelete',
        ]);

    Route::resource('/products' , ProductsControler::class)
    ->names([
        'index' => 'productsindex',
        'create' => 'productscreate',
        'store' => 'productsstore',
        'edit' => 'productsedit',
        'update' => 'productsupdate',
        'destroy' => 'productsdelete',
    ]);  
    

    Route::get('/profile',[ProfileController::class,'edit'])->name('profileedit');
    Route::patch('/profile',[ProfileController::class,'update'])->name('profileupdate');


});
