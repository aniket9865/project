<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
//    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
//    {
//        $selectedCategorySlug = $categorySlug;
//        $selectedSubCategorySlug = $subCategorySlug;
//        $brandsArray = [];
//
//        // Retrieve categories with subcategories and brands
//        $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
//        $brands = Brand::orderBy('name', 'ASC')->where('status', 1)->get();
//
//        // Initialize products query
//        $productsQuery = Product::where('status', 1);
//
//        // Apply category filter
//        if (!empty($selectedCategorySlug)) {
//            $category = Category::where('slug', $selectedCategorySlug)->first();
//            if ($category) {
//                $productsQuery->where('category_id', $category->id);
//            }
//        }
//
//        // Apply subcategory filter
//        if (!empty($selectedSubCategorySlug)) {
//            $subCategory = SubCategory::where('slug', $selectedSubCategorySlug)->first();
//            if ($subCategory) {
//                $productsQuery->where('sub_category_id', $subCategory->id);
//            }
//        }
//
//        // Apply brand filters
//        if (!empty($request->get('brand'))) {
//            $brandsArray = explode(',', $request->get('brand'));
//            $productsQuery->whereIn('brand_id', $brandsArray);
//        }
//
//        // Apply search filter
//        if (!empty($request->get('search'))) {
//            $search = $request->get('search');
//            $productsQuery->where('title', 'like', "%{$search}%");
//        }
//
//        // Retrieve products with applied filters
//        $products = $productsQuery->orderBy('id', 'DESC')->get();
//
//        // Pass data to the view
//        $data = [
//            'categories' => $categories,
//            'brands' => $brands,
//            'products' => $products,
//            'categorySelected' => $selectedCategorySlug,
//            'subCategorySelected' => $selectedSubCategorySlug,
//            'brandsArray' => $brandsArray,
//        ];
//
//        return view('front.shop', $data);
//    }

    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
    {
        $selectedCategorySlug = $categorySlug;
        $selectedSubCategorySlug = $subCategorySlug;
        $brandsArray = [];

        // Retrieve categories with subcategories and brands
        $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'ASC')->where('status', 1)->get();

        // Initialize products query
        $productsQuery = Product::where('status', 1);

        // Apply category filter
        if (!empty($selectedCategorySlug)) {
            $category = Category::where('slug', $selectedCategorySlug)->first();
            if ($category) {
                $productsQuery->where('category_id', $category->id);
            }
        }

        // Apply subcategory filter
        if (!empty($selectedSubCategorySlug)) {
            $subCategory = SubCategory::where('slug', $selectedSubCategorySlug)->first();
            if ($subCategory) {
                $productsQuery->where('sub_category_id', $subCategory->id);
            }
        }

        // Apply brand filters
        if (!empty($request->get('brand'))) {
            $brandsArray = explode(',', $request->get('brand'));
            $productsQuery->whereIn('brand_id', $brandsArray);
        }

        // Apply search filter
        if (!empty($request->get('search'))) {
            $search = $request->get('search');
            $productsQuery->where('title', 'like', "%{$search}%");
        }

        // Retrieve products with pagination
        $products = $productsQuery->orderBy('id', 'DESC')->paginate(12); // Adjust the number of items per page as needed

        // Pass data to the view
        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'categorySelected' => $selectedCategorySlug,
            'subCategorySelected' => $selectedSubCategorySlug,
            'brandsArray' => $brandsArray,
        ];

        return view('front.shop', $data);
    }


    public function product($slug)
//    {
//        $product = Product::where('slug', $slug)->with('image')->first();
//
//        //dd($product); // Check the structure of $product
//
//        if ($product === null) {
//            abort(404);
//        }
//
//        $data['product'] = $product;
//
//        return view('front.product', $data);
//    }

    {
        // Fetch the product using the slug
        $product = Product::where('slug', $slug)->with('image')->first();

        // Fetch related products or whatever logic you use to get products
        $products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4) // Limit number of related products
            ->get();

        // Return the view with both the product and the related products
        return view('front.product', compact('product', 'products'));
    }

}
