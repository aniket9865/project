<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
// Fetch the product with its image
        $product = Product::with('image')->find($request->id);

        if (!$product) { // Corrected the null check
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        $cartContent = Cart::content();
        $productAlreadyExist = false;

        foreach ($cartContent as $item) {
            if ($item->id == $product->id) {
                $productAlreadyExist = true;
                break; // Exit loop early if the product is found
            }
        }

        if (!$productAlreadyExist) {
            Cart::add($product->id, $product->title, 1, $product->price, [
                'image' => $product->image->count() > 0 ? $product->image->first()->image : ''
            ]);
            $status = true;
            $message = $product->title . ' added to cart';
        } else {
            $status = false;
            $message = $product->title . ' is already in the cart';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function cart()
    {
        $cartContent = Cart::content();
        return view('front.cart', ['cartContent' => $cartContent]); // Pass data to the view
    }
}
