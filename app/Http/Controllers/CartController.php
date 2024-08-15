<?php
//
//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use App\Models\Product;
//use Gloudemans\Shoppingcart\Facades\Cart;
//
//class CartController extends Controller
//{
//    public function addToCart(Request $request)
//    {
//        $product = Product::find($request->id);
//
//        if (!$product) {
//            return response()->json([
//                'status' => false,
//                'message' => 'Product not found'
//            ]);
//        }
//
//        $cartContent = Cart::content();
//        $productAlreadyExist = false;
//
//        foreach ($cartContent as $item) {
//            if ($item->id == $product->id) {
//                $productAlreadyExist = true;
//                break;
//            }
//        }
//
//        $options = [
//            'image' => $product->image, // Assuming 'image' is a column in your products table
//        ];
//
//
//        if (!$productAlreadyExist) {
//            Cart::add($product->id, $product->title, 1, $product->price, $options);
//            $status = true;
//            $message = $product->title . ' added to cart';
//        } else {
//            $status = false;
//            $message = $product->title . ' is already in the cart';
//        }
//
//        return response()->json([
//            'status' => $status,
//            'message' => $message
//        ]);
//    }
//
//
//    public function cart()
//    {
//        $cartContent = Cart::content();
////        dd($cartContent);
//        return view('front.cart', ['cartContent' => $cartContent]); // Pass data to the view
//    }
//}


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
        $cart = Cart::update($request->rowId, $request->qty);

        return response()->json([
            'status' => true,
            'newTotal' => $cart->items[$request->rowId]['price'] * $request->qty, // Update this according to your cart structure
            'cartSummary' => [
                'subtotal' => Cart::subtotal(),
                'shipping' => Cart::shipping(),
                'total' => Cart::total()
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
                'shipping' => Cart::shipping(),
                'total' => Cart::total()
            ]
        ]);
    }



//    public function updateCart(Request $request)
//    {
//        $rowId = $request->rowId;
//        $qty = $request->qty;
//
//        if (Cart::update($rowId, $qty)) {
//            return response()->json([
//                'status' => true,
//                'message' => 'Cart updated successfully'
//            ]);
//        }
//
//        return response()->json([
//            'status' => false,
//            'message' => 'Failed to update cart'
//        ]);
//    }
//
//    public function removeFromCart(Request $request)
//    {
//        $rowId = $request->rowId;
//
//        if (Cart::remove($rowId)) {
//            return response()->json([
//                'status' => true,
//                'message' => 'Item removed from cart'
//            ]);
//        }
//
//        return response()->json([
//            'status' => false,
//            'message' => 'Failed to remove item from cart'
//        ]);
//    }

    public function cart()
    {
        $cartContent = Cart::content();
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    }
}
