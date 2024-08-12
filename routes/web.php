<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\Product\ProductController;

// Default route
//Route::get('/', function () {
//    return view('welcome');
//});
//Route for Front
Route::get('/',[\App\Http\Controllers\FrontController::class,'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subCategorySlug?}',[\App\Http\Controllers\ShopController::class,'index'])->name('front.shop');
Route::get('/product/{productSlug?}',[\App\Http\Controllers\ShopController::class,'product'])->name('front.product');
Route::get('/cart',[\App\Http\Controllers\CartController::class,'cart'])->name('front.cart');
Route::post('/add=to-cart',[\App\Http\Controllers\CartController::class,'addToCart'])->name('front.addToCart');



// Routes for user account
Route::prefix('account')->group(function () {
    // Guest routes (accessible only when not authenticated)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index'])->name('account.login');
        Route::post('/authenticate', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('account.authenticate');
        Route::get('/register', [\App\Http\Controllers\LoginController::class, 'register'])->name('account.register');
        Route::post('/process-register', [\App\Http\Controllers\LoginController::class, 'processRegister'])->name('account.processRegister');
    });

    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('account.logout');
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('account.dashboard');



    });
});

// Routes for admin
Route::prefix('admin')->group(function () {
    // Admin guest routes (accessible only when not authenticated as admin)
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\admin\LoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [\App\Http\Controllers\admin\LoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    // Admin authenticated routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [\App\Http\Controllers\admin\LoginController::class, 'logout'])->name('admin.logout');

        // Category Routes
        Route::get('/categories', [\App\Http\Controllers\admin\CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [\App\Http\Controllers\admin\CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [\App\Http\Controllers\admin\CategoryController::class, 'store'])->name('categories.store');
         Route::get('/categories/{category}/edit', [\App\Http\Controllers\admin\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [\App\Http\Controllers\admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [\App\Http\Controllers\admin\CategoryController::class, 'destroy'])->name('categories.destroy');

        //temp-images.create
        Route::post('/admin/temp-images', [\App\Http\Controllers\admin\TempImageController::class, 'store'])->name('temp-images.store');
        Route::delete('/admin/temp-images', [\App\Http\Controllers\admin\TempImageController::class, 'delete'])->name('temp-images.delete');


        //Sub-category Route
        Route::get('/sub_categories', [\App\Http\Controllers\admin\SubCategoryController::class, 'index'])->name('sub_categories.index');
        Route::get('/sub_categories/create', [\App\Http\Controllers\admin\SubCategoryController::class, 'create'])->name('sub_categories.create');
        Route::post('/sub_categories', [\App\Http\Controllers\admin\SubCategoryController::class, 'store'])->name('sub_categories.store');
        Route::get('/sub_categories/{sub_category}/edit', [\App\Http\Controllers\admin\SubCategoryController::class, 'edit'])->name('sub_categories.edit');
        Route::put('/sub_categories/{sub_category}', [\App\Http\Controllers\admin\SubCategoryController::class, 'update'])->name('sub_categories.update');
        Route::delete('/sub_categories/{sub_category}', [\App\Http\Controllers\admin\SubCategoryController::class, 'destroy'])->name('sub_categories.destroy');

        Route::resource('subcategories', \App\Http\Controllers\admin\SubCategoryController::class);

        // Brands Route
        Route::get('/brands', [\App\Http\Controllers\admin\BrandsControlller::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [\App\Http\Controllers\admin\BrandsControlller::class, 'create'])->name('brands.create');
        Route::post('/brands', [\App\Http\Controllers\admin\BrandsControlller::class, 'store'])->name('brands.store');
        Route::get('/brands/{brand}/edit', [\App\Http\Controllers\admin\BrandsControlller::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brand}', [\App\Http\Controllers\admin\BrandsControlller::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [\App\Http\Controllers\admin\BrandsControlller::class, 'destroy'])->name('brands.destroy');

//        // Products Route
        Route::get('/products', [\App\Http\Controllers\admin\ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [\App\Http\Controllers\admin\ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [\App\Http\Controllers\admin\ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [\App\Http\Controllers\admin\ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [\App\Http\Controllers\admin\ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [\App\Http\Controllers\admin\ProductController::class, 'destroy'])->name('products.destroy');



        Route::get('/products-subcategories', [\App\Http\Controllers\admin\ProductSubCategoryController::class, 'index'])->name('product.subcategories.index');

        Route::get('products-images',[\App\Http\Controllers\admin\ProductImageController::class,'store'])->name('product-images.store');
        Route::delete('product-image', [\App\Http\Controllers\admin\ProductImageController::class, 'delete'])->name('product-images.delete');


// Subcategory AJAX Route
        Route::get('subcategories/get', [Su::class, 'getSubcategories'])->name('subcategories.get');


        // Orders Route
        Route::get('/orders', [\App\Http\Controllers\admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [\App\Http\Controllers\admin\OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [\App\Http\Controllers\admin\OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}/edit', [\App\Http\Controllers\admin\OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{order}', [\App\Http\Controllers\admin\OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [\App\Http\Controllers\admin\OrderController::class, 'destroy'])->name('orders.destroy');

        // Pages Route
        Route::get('/pages', [\App\Http\Controllers\admin\PageController::class, 'index'])->name('page.index');
        Route::get('/pages/create', [\App\Http\Controllers\admin\PageController::class, 'create'])->name('page.create');
        Route::post('/pages', [\App\Http\Controllers\admin\PageController::class, 'store'])->name('page.store');
        Route::get('/pages/{page}/edit', [\App\Http\Controllers\admin\PageController::class, 'edit'])->name('page.edit');
        Route::put('/pages/{page}', [\App\Http\Controllers\admin\PageController::class, 'update'])->name('page.update');
        Route::delete('/pages/{page}', [\App\Http\Controllers\admin\PageController::class, 'destroy'])->name('page.destroy');

    });
});

//// Product Routes
//Route::get('/products', [ProductController::class, 'index'])->name('products.index');
//Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
//Route::post('/products', [ProductController::class, 'store'])->name('products.store');
//Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
//Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
//Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
