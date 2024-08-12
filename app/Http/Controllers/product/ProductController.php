<?php
//
//namespace App\Http\Controllers\product;
//
//use App\Http\Controllers\Controller;
//use App\Models\Product;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
//
//class ProductController extends Controller
//{
//    //This method will show products page
//    public function index()
//    {
//        $products = Product::orderBy('created_at','DESC')->get();
//        return view('products.list',[
//            'products' => $products
//        ]);
//
//
//    }
//
//    //This method will show create a product page
//    public function create()
//    {
//        return view('products.create');
//    }
//
//// This method will store a product in the database
//    public function store(Request $request)
//    {
//        // Validation rules
//        $rules = [
//            'name' => 'required|min:5',
//            'sku' => 'required|min:3',
//            'price' => 'required|numeric|min:1',
//        ];
//
//        // If an image is uploaded, add image validation rules
//        if ($request->hasFile('image')) {
//            $rules['image'] = 'image';
//        }
//
//        // Validate the request
//        $validator = Validator::make($request->all(), $rules);
//
//        // If validation fails, redirect back to the create form with errors and input
//        if ($validator->fails()) {
//            return redirect()->route('products.create')->withErrors($validator)->withInput();
//        }
//
//        // Create a new product instance
//        $product = new Product();
//        $product->name = $request->input('name');
//        $product->sku = $request->input('sku');
//        $product->price = $request->input('price');
//        $product->save();
//
//        // If an image is uploaded, handle the image upload
//        if ($request->hasFile('image')) {
//            $image = $request->file('image');
//            $ext = $image->getClientOriginalExtension();
//            $imageName = time() . '.' . $ext;
//
//            // Save the image to the product directory
//            $image->move(public_path('uploads/products'), $imageName);
//
//            // Save the image name in the database
//            $product->image = $imageName;
//            $product->save();
//        }
//
//        // Redirect to the product index page with a success message
//        return redirect()->route('products.index')->with('success', 'Product added successfully');
//    }
//
//
//    //This method will edit product page
//    public function edit($id)
//    {
//        // Find the product by ID
//        $product = Product::findOrFail($id);
//
//        // Return the edit view with the product data
//        return view('products.edit', [
//            'product' => $product
//        ]);
//
//    }
//
//
//// This method will update product in db
//    public function update(Request $request, $id)
//    {
//        $rules = [
//            'name' => 'required|min:5',
//            'sku' => 'required|min:3',
//            'price' => 'required|numeric|min:1',
//        ];
//
//        $validator = Validator::make($request->all(), $rules);
//
//        if ($validator->fails()) {
//            return redirect()->route('products.edit', $id)->withErrors($validator)->withInput();
//        }
//
//        $product = Product::find($id);
//        if (!$product) {
//            return redirect()->route('products.index')->with('error', 'Product not found');
//        }
//
//        $product->name = $request->input('name');
//        $product->sku = $request->input('sku');
//        $product->price = $request->input('price');
//        $product->save();
//
//        return redirect()->route('products.index')->with('success', 'Product updated successfully');
//    }
//
//    //This method will delete product page
//    public function destroy()
//    {
//
//    }
//}


namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // This method will show products page
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('products.list', [
            'products' => $products
        ]);
    }

    // This method will show create a product page
    public function create()
    {
        return view('products.create');
    }

    // This method will store a product in the database
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric|min:1',
        ];

        // If an image is uploaded, add image validation rules
        if ($request->hasFile('image')) {
            $rules['image'] = 'image';
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, redirect back to the create form with errors and input
        if ($validator->fails()) {
            return redirect()->route('products.create')->withErrors($validator)->withInput();
        }

        // Create a new product instance
        $product = new Product();
        $product->name = $request->input('name');
        $product->sku = $request->input('sku');
        $product->price = $request->input('price');
        $product->save();

        // If an image is uploaded, handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            // Save the image to the product directory
            $image->move(public_path('uploads/products'), $imageName);

            // Save the image name in the database
            $product->image = $imageName;
            $product->save();
        }

        // Redirect to the product index page with a success message
        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    // This method will show the edit product page
    public function edit($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Return the edit view with the product data
        return view('products.edit', [
            'product' => $product
        ]);
    }

    // This method will update a product in the database
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $id)->withErrors($validator)->withInput();
        }

        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        $product->name = $request->input('name');
        $product->sku = $request->input('sku');
        $product->price = $request->input('price');
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // This method will delete a product from the database
    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::find($id);

        // If product not found, redirect with an error message
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        // Delete the product image if it exists
        if ($product->image) {
            $imagePath = public_path('uploads/products/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the product
        $product->delete();

        // Redirect to the product index page with a success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
