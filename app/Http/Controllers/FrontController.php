<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\Product;
//use App\Models\Wishlist;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//
//class FrontController extends Controller
//{
//    public function index()
//    {
//
//        $products = Product::where('is_featured', 'Yes')->orderBy('id','DESC')->take(8)->where('status',1)->get();
//        $data['featuredProducts'] = $products;
//
//        $latestProduct = Product::orderBy('id','DESC')->where('status',1)->take(8)->get();
//        $data['latestProduct'] = $latestProduct;
//
//        return view('front.home',$data);
//    }
//
//    public function addToWishlist(Request $request)
//    {
//        // Check if the user is authenticated
//        if (!Auth::check()) {
//            // Store the intended URL and return an error response
//            session(['url.intended' => url()->previous()]);
//            return response()->json([
//                'status' => false,
//                'message' => 'You need to be logged in to add items to your wishlist.'
//            ]);
//        }
//
//        // Create a new wishlist entry
//        $wishlist = new Wishlist()t;
//        $wishlist->user_id = Auth::user()->id;
//        $wishlist->product_id = $request->id;
//        $wishlist->save();
//
//        // Return a success response
//        return response()->json([
//            'status' => true,
//            'message' => 'Product added to your wishlist.'
//        ]);
//    }
//
//
//}


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index()
    {
        // Get featured products
        $products = Product::where('is_featured', 'Yes')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();
        $data['featuredProducts'] = $products;

        // Get latest products
        $latestProduct = Product::where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();
        $data['latestProduct'] = $latestProduct;

        return view('front.home', $data);
    }

    public function addToWishlist(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Store the intended URL and return an error response
            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false,
                'message' => 'You need to be logged in to add items to your wishlist.'
            ]);
        }

        // Check if the product exists
        $product = Product::find($request->id);
        if ($product === null) {
            return response()->json([
                'status' => false,
                'message' => '<div class="alert alert-danger">Product not found.</div>'
            ]);
        }

        // Update or create the wishlist entry
        Wishlist::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id
            ],
            []
        );

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => '<div class="alert alert-success"><strong>' . $product->title . '</strong> added to your wishlist.</div>'
        ]);
    }

    public function wishlist()
    {
        // Get all wishlists for the authenticated user
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();

        // Pass wishlists data to the view
        return view('front.account.wishlist', ['wishlists' => $wishlists]);
    }


    public function removeProductFromWishList(Request $request)
    {
        // Find the wishlist entry for the authenticated user and the specified product
        $wishlist = Wishlist::where('user_id', Auth::user()->id)
            ->where('product_id', $request->id)
            ->first();

        // Check if the wishlist entry exists
        if ($wishlist === null) {
            // If not found, flash an error message and return a response
            session()->flash('error', 'Product not found in wishlist.');
            return response()->json([
                'status' => false,
                'message' => 'Product not found in wishlist.'
            ]);
        } else {
            // If found, delete the wishlist entry
            $wishlist->delete();
            // Flash a success message and return a response
            session()->flash('success', 'Product removed successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Product removed successfully.'
            ]);
        }
    }

//    public function showProduct($slug)
//    {
//        $product = Product::where('slug', $slug)->firstOrFail();
//        return view('shop.single', compact('product'));
//    }


}
