<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
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
                break;
            }
        }

        if (!$productAlreadyExist) {
            Cart::add($product->id, $product->title, 1, $product->price, ['image' => $product->image]);
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

    public function updateCart(Request $request)
    {
        Cart::update($request->rowId, $request->qty);

        return response()->json([
            'status' => true,
            'cartSummary' => [
                'subtotal' => Cart::subtotal(),
                'shipping' => $this->calculateShipping(), // Method to calculate shipping
                'total' => Cart::total() + $this->calculateShipping() // Add shipping to total
            ]
        ]);
    }

    public function removeFromCart(Request $request)
    {
        Cart::remove($request->rowId);

        return response()->json([
            'status' => true,
            'cartSummary' => [
                'subtotal' => Cart::subtotal(),
                'shipping' => $this->calculateShipping(), // Method to calculate shipping
                'total' => Cart::total() + $this->calculateShipping() // Add shipping to total
            ]
        ]);
    }

    public function cart()
    {
        $cartContent = Cart::content();
        $subtotal = Cart::subtotal();
//        $shipping = $this->calculateShipping(); // Calculate shipping
//        $total = Cart::total() + $shipping; // Add shipping to total

        return view('front.cart', [
            'cartContent' => $cartContent,
            'subtotal' => $subtotal,
//            'shipping' => $shipping,
//            'total' => $total
        ]);
    }


    private function calculateShipping()
    {
        // Implement your logic to calculate shipping cost here
        // For example, you can return a fixed rate or calculate based on cart value
        return 20.00; // Static value for demonstration
    }
}

