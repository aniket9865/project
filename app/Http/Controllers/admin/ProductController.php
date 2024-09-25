<?php
////namespace App\Http\Controllers\admin;
////
////use App\Http\Controllers\Controller;
////use App\Models\Product;
////use App\Models\Category;
////use App\Models\Brand;
////use Illuminate\Http\Request;
////use Illuminate\Support\Facades\Storage;
////
////class ProductController extends Controller
////{
////    public function index()
////    {
////        $products = Product::all();
////        return view('admin.product.list', compact('products'));
////    }
////
////    public function create()
////    {
////        $categories = Category::all();
////        $brands = Brand::all();
////        $subcategories = collect();
////        return view('admin.product.create', compact('categories', 'brands', 'subcategories'));
////    }
////
////    public function store(Request $request)
////    {
////        $rules = [
////            'title' => 'required|string|max:255',
////            'slug' => 'required|string|max:255|unique:products,slug',
////            'description' => 'nullable|string',
////            'price' => 'required|numeric|min:0',
////            'compare_price' => 'nullable|numeric|min:0',
////            'sku' => 'nullable|string|max:255|unique:products,sku',
////            'barcode' => 'nullable|string|max:255|unique:products,barcode',
////            'track_qty' => 'nullable|in:Yes,No',
////            'qty' => 'nullable|integer|min:0',
////            'status' => 'required|in:0,1',
////            'category_id' => 'required|exists:categories,id',
////            'sub_category_id' => 'nullable|exists:sub_categories,id',
////            'brand_id' => 'nullable|exists:brands,id',
////            'is_featured' => 'nullable|in:Yes,No',
////            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
////        ];
////
////        if ($request->track_qty === 'Yes') {
////            $rules['qty'] = 'required|integer|min:0';
////        }
////
////        $request->validate($rules);
////
////        $imagePath = null;
////        if ($request->hasFile('image')) {
////            $file = $request->file('image');
////            $imagePath = $file->store('uploads/products', 'public');
////        }
////
////        // Debugging: Check if the image path is correctly stored
////        // dd($request->all(), $imagePath);
////
////        // Create the product with image path
////        Product::create(array_merge(
////            $request->except('image'),
////            ['image' => $imagePath]
////        ));
////
////        return redirect()->route('products.index')->with('success', 'Product created successfully.');
////    }
////
////    public function update(Request $request, $id)
////    {
////        $rules = [
////            'title' => 'required|string|max:255',
////            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
////            'description' => 'nullable|string',
////            'price' => 'required|numeric|min:0',
////            'compare_price' => 'nullable|numeric|min:0',
////            'sku' => 'nullable|string|max:255|unique:products,sku,' . $id,
////            'barcode' => 'nullable|string|max:255|unique:products,barcode,' . $id,
////            'track_qty' => 'nullable|in:Yes,No',
////            'qty' => 'nullable|integer|min:0',
////            'status' => 'required|in:0,1',
////            'category_id' => 'required|exists:categories,id',
////            'sub_category_id' => 'nullable|exists:sub_categories,id',
////            'brand_id' => 'nullable|exists:brands,id',
////            'is_featured' => 'nullable|in:Yes,No',
////            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
////        ];
////
////        if ($request->track_qty === 'Yes') {
////            $rules['qty'] = 'required|integer|min:0';
////        }
////
////        $request->validate($rules);
////
////        $product = Product::findOrFail($id);
////
////        $imagePath = $product->image; // Keep existing image if no new one is uploaded
////        if ($request->hasFile('image')) {
////            // Delete old image if exists
////            if ($product->image && Storage::exists('public/' . $product->image)) {
////                Storage::delete('public/' . $product->image);
////            }
////
////            $file = $request->file('image');
////            $imagePath = $file->store('uploads/products', 'public');
////        }
////
////        $product->update(array_merge(
////            $request->except('image'),
////            ['image' => $imagePath]
////        ));
////
////        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
////    }
////
////    public function show($id)
////    {
////        $product = Product::findOrFail($id);
////        return view('admin.product.show', compact('product'));
////    }
////
////    public function edit($id)
////    {
////        $product = Product::findOrFail($id);
////        $categories = Category::all();
////        $brands = Brand::all();
////        $subcategories = collect(); // Adjust as needed
////        return view('admin.product.edit', compact('product', 'categories', 'brands', 'subcategories'));
////    }
////
////    public function destroy($id)
////    {
////        $product = Product::findOrFail($id);
////
////        // Delete the image file if exists
////        if ($product->image && Storage::exists('public/' . $product->image)) {
////            Storage::delete('public/' . $product->image);
////        }
////
////        $product->delete();
////        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
////    }
////}
//
//
//namespace App\Http\Controllers\admin;
//
//use App\Http\Controllers\Controller;
//use App\Models\Product;
//use App\Models\Category;
//use App\Models\Brand;
//use App\Models\SubCategory;
//
//// Ensure you import the SubCategory model
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
//
//class ProductController extends Controller
//{
//    /**
//     * Display a listing of the products.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @return \Illuminate\View\View
//     */
//    public function index(Request $request)
//    {
//        $search = $request->input('search');
//        $products = Product::when($search, function ($query, $search) {
//            return $query->where('title', 'like', "%{$search}%");
//        })->latest()->paginate(10);
//
//        return view('admin.product.list', compact('products'));
//    }
//
//    /**
//     * Show the form for creating a new product.
//     *
//     * @return \Illuminate\View\View
//     */
//    public function create()
//    {
//        $categories = Category::all(); // Fetch all categories
//        $brands = Brand::all(); // Fetch all brands
//        $subcategories = SubCategory::all(); // Fetch all subcategories
//
//        return view('admin.product.create', compact('categories', 'brands', 'subcategories'));
//    }
//
//    /**
//     * Store a newly created product in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function store(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'title' => 'required|string|max:255',
//            'slug' => 'required|string|max:255|unique:products,slug',
//            'description' => 'nullable|string',
//            'price' => 'required|numeric|min:0',
//            'compare_price' => 'nullable|numeric|min:0',
//            'sku' => 'nullable|string|max:255|unique:products,sku',
//            'barcode' => 'nullable|string|max:255|unique:products,barcode',
//            'track_qty' => 'nullable|in:Yes,No',
//            'qty' => 'nullable|integer|min:0',
//            'status' => 'required|in:0,1',
//            'category_id' => 'required|exists:categories,id',
//            'sub_category_id' => 'nullable|exists:sub_categories,id',
//            'brand_id' => 'nullable|exists:brands,id',
//            'is_featured' => 'nullable|in:Yes,No',
//            'image' => 'nullable|string', // Change validation based on your requirement
//        ]);
//
//        if ($validator->passes()) {
//            $product = new Product();
//            $product->fill($request->except('image'));
//            $product->qty = $request->track_qty === 'Yes' ? $request->input('qty') : null;
//
//            // Handle image assignment
//            if ($request->has('image')) {
//                $product->image = $request->input('image');
//            }
//
//            $product->save();
//
//            return response()->json([
//                'status' => true,
//                'message' => 'Product has been created successfully',
//                'redirect' => route('admin.products.index'), // Add redirect route
//            ]);
//        } else {
//            return response()->json([
//                'status' => false,
//                'errors' => $validator->errors()
//            ]);
//        }
//    }
//
//
//    /**
//     * Show the form for editing the specified product.
//     *
//     * @param int $id
//     * @return \Illuminate\View\View
//     */
//    public function edit($id)
//    {
//        $product = Product::findOrFail($id);
//        $categories = Category::all(); // Fetch all categories
//        $brands = Brand::all(); // Fetch all brands
//        $subcategories = SubCategory::all(); // Fetch all subcategories
//
//        return view('admin.product.edit', compact('product', 'categories', 'brands', 'subcategories'));
//    }
//
//    /**
//     * Update the specified product in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @param int $id
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function update(Request $request, $id)
//    {
//        $product = Product::findOrFail($id);
//
//        $validator = Validator::make($request->all(), [
//            'title' => 'required|string|max:255',
//            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
//            'description' => 'nullable|string',
//            'price' => 'required|numeric|min:0',
//            'compare_price' => 'nullable|numeric|min:0',
//            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
//            'barcode' => 'nullable|string|max:255|unique:products,barcode,' . $product->id,
//            'track_qty' => 'nullable|in:Yes,No',
//            'qty' => 'nullable|integer|min:0',
//            'status' => 'required|in:0,1',
//            'category_id' => 'required|exists:categories,id',
//            'sub_category_id' => 'nullable|exists:sub_categories,id',
//            'brand_id' => 'nullable|exists:brands,id',
//            'is_featured' => 'nullable|in:Yes,No',
//            'image' => 'nullable|string', // Change validation based on your requirement
//        ]);
//
//        if ($validator->passes()) {
//            $product->fill($request->except('image'));
//            $product->qty = $request->track_qty === 'Yes' ? $request->input('qty') : null;
//
//            // Handle image update
//            if ($request->has('image')) {
//                $product->image = $request->input('image');
//            }
//
//            $product->save();
//
//            return response()->json([
//                'status' => true,
//                'message' => 'Product has been updated successfully',
//            ]);
//        } else {
//            return response()->json([
//                'status' => false,
//                'errors' => $validator->errors()
//            ]);
//        }
//    }
//
//    /**
//     * Remove the specified product from storage.
//     *
//     * @param int $id
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function destroy($id)
//    {
//        $product = Product::findOrFail($id);
//
//        // Delete the product image if it exists
//        if ($product->image) {
//            // Remove image handling logic here
//        }
//
//        $product->delete();
//
//        return response()->json([
//            'status' => true,
//            'message' => 'Product has been deleted successfully',
//        ]);
//    }
//}


namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('admin.product.list', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        $brands = Brand::all(); // Fetch all brands
        $subcategories = SubCategory::all(); // Fetch all subcategories

        return view('admin.product.create', compact('categories', 'brands', 'subcategories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'shipping_returns' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'barcode' => 'nullable|string|max:255|unique:products,barcode',
            'track_qty' => 'nullable|in:Yes,No',
            'qty' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_featured' => 'required|in:Yes,No',
            'image' => 'nullable|string', // Adjust validation based on your requirement
        ]);

        if ($validator->passes()) {
            $product = new Product();
            $product->fill($request->except('image'));
            $product->qty = $request->track_qty === 'Yes' ? $request->input('qty') : null;

            // Handle image assignment
            if ($request->has('image')) {
                $product->image = $request->input('image');
            }

            $product->save();

            return redirect()->route('products.index')->with('success', 'Product has been created successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Fetch all categories
        $brands = Brand::all(); // Fetch all brands
        $subcategories = SubCategory::all(); // Fetch all subcategories

        return view('admin.product.edit', compact('product', 'categories', 'brands', 'subcategories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'related_products' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:255|unique:products,barcode,' . $product->id,
            'track_qty' => 'nullable|in:Yes,No',
            'qty' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_featured' => 'required|in:Yes,No',
            'image' => 'nullable|string', // Adjust validation based on your requirement
        ]);

        if ($validator->passes()) {
            $product->fill($request->except('image'));
            $product->qty = $request->track_qty === 'Yes' ? $request->input('qty') : null;

            // Handle image update
            if ($request->has('image')) {
                $product->image = $request->input('image');
            }

            $product->save();

            return redirect()->route('products.index')->with('success', 'Product has been updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete the product image if it exists (image handling logic removed)
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product has been deleted successfully',
            'redirect' => route('products.index'),
        ]);
    }


}
