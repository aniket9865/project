<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

        $item = Cart::get($request->rowId);

        return response()->json([
            'status' => true,
            'newTotal' => $item->price * $request->qty,
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

    public function cart()
    {
        $cartContent = Cart::content();
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    }

    public function checkout()
    {
        if (Cart::count() == 0) {
            return redirect()->route('front.home');
        }

        // If the user is not logged in, redirect to the login page
        if (!Auth::check()) {
            // Store the current URL in the session if 'url.intended' is not set
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            // Redirect to the login page
            return redirect()->route('account.login');
        }

        // Get customer's address
        $customerAddress = CustomerAddress::where('user_id', Auth::user()->id)->first();

        // Clear the 'url.intended' from the session after redirect
        session()->forget('url.intended');

        $countries = Country::orderBy('name', 'ASC')->get();

        // Calculate shipping here
        if ($customerAddress != '') {
            $userCountry = $customerAddress->country_id;
            $shippingInfo = ShippingCharge::where('country_id', $userCountry)->first();
            $totalQty = 0;
            $totalShippingCharge = 0;
            $grandTotal = 0;

            // Calculate total quantity from the cart
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }

            // Calculate total shipping charge
            $totalShippingCharge = $totalQty * $shippingInfo->amount;

            // Calculate grand total (subtotal + shipping)
            $grandTotal = Cart::subtotal(2, '.', '') + $totalShippingCharge;
        } else {
            $grandTotal = Cart::subtotal(2, '.', '');
            $totalShippingCharge = 0;
        }

        return view('front.checkout', [
            'countries' => $countries,
            'customerAddress' => $customerAddress,
            'totalShippingCharge' => $totalShippingCharge,
            'grandTotal' => $grandTotal
        ]);
    }

    public function processCheckout(Request $request)
    {
        // Step 1: Apply Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
            'apartment' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Step 2: Update or Create Customer Address
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ]
        );

        // Step 3: Store data in orders table
        $shipping = 0;
        $discount = 0;
        $subTotal = Cart::subtotal(2, '.', '');
        $grandTotal = $subTotal + $shipping;

        // Calculate Shipping
        $shippingInfo = ShippingCharge::where('country_id', $request->country)->first(); // Corrected variable names
        $totalQty = 0; // Initialize total quantity

        foreach (Cart::content() as $item) {
            $totalQty += $item->qty; // Accumulate the quantity of each item
        }

        if ($shippingInfo != null) {
            $shipping = $totalQty * $shippingInfo->amount; // Corrected variable assignment and calculation
            $grandTotal = $subTotal + $shipping; // Corrected variable assignment
        } else {
            $shippingInfo = ShippingCharge::where('country_id', '243')->first(); // Corrected variable names
            if ($shippingInfo != null) { // Check if shipping info is found
                $shipping = $totalQty * $shippingInfo->amount; // Calculate shipping charge
                $grandTotal = $subTotal + $shipping; // Calculate grand total
            }
        }

        $order = new Order;
        $order->subtotal = $subTotal;
        $order->shipping = $shipping;
        $order->grand_total = $grandTotal;
        $order->payment_status = 'not paid';
        $order->status = 'pending';
        $order->user_id = $user->id;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->mobile = $request->mobile;
        $order->address = $request->address;
        $order->apartment = $request->apartment;
        $order->state = $request->state;
        $order->city = $request->city;
        $order->zip = $request->zip;
        $order->notes = $request->order_notes;
        $order->country_id = $request->country;

        $order->save();

        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem;
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->name = $item->name;
            $orderItem->qty = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->qty;
            $orderItem->save();

            //Update Product Stack
            // Debugging Step: Check if product is being retrieved
            $productData = Product::find($item->id);
            if (!$productData) {
                Log::error('Product not found for ID: ' . $item->id);
                continue; // Skip if product not found
            }

            if (strtolower($productData->track_qty) == 'yes') {
                $currentQty = $productData->qty;
                $updatedQty = $currentQty - $item->qty;

                if ($updatedQty < 0) {
                    // Handle case where quantity would go negative
                    Log::warning('Product ID ' . $item->id . ' would have negative stock.');
                    $updatedQty = 0;  // Optionally, set it to 0 if you'd rather have no negative stock
                }

                $productData->qty = $updatedQty;
                $productData->save();
            }
        }

        // Clear cart after successful order
        Cart::destroy();

        // Flash success message
        session()->flash('success', 'You have successfully placed your order!');

        return response()->json([
            'message' => 'Order Successful',
            'orderId' => $order->id,
            'status' => true
        ], 200);
    }

    public function thankyou($id)
    {
        return view('front.thanks', compact('id'));
    }

    public function getOrderSummery(Request $request)
    {
        $subTotal = Cart::subtotal(2, '.', '');
        // Ensure a valid country_id is provided
        if ($request->country_id > 0) {
            //            $subTotal = Cart::subtotal(2, '.', ''); // Get the subtotal
            $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();
            $totalQty = 0;

            // Calculate total quantity from the cart
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty; // Corrected variable assignment
            }

            if ($shippingInfo !== null) { // Check if shipping info for the selected country is available
                $shippingCharge = $totalQty * $shippingInfo->amount; // Calculate shipping charge
                $grandTotal = $subTotal + $shippingCharge; // Calculate grand total

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2), // Format the grand total
                    'shippingCharge' => number_format($shippingCharge, 2), // Format the shipping charge
                ]);
            } else {
                // If no shipping info for the selected country, check for 'rest_of_world'
                $shippingInfo = ShippingCharge::where('country_id', '243')->first();

                if ($shippingInfo !== null) { // Check if shipping info for 'rest_of_world' is available
                    $shippingCharge = $totalQty * $shippingInfo->amount; // Calculate shipping charge
                    $grandTotal = $subTotal + $shippingCharge; // Calculate grand total

                    return response()->json([
                        'status' => true,
                        'grandTotal' => number_format($grandTotal, 2), // Format the grand total
                        'shippingCharge' => number_format($shippingCharge, 2), // Format the shipping charge
                    ]);
                } else {
                    // If no shipping info found for either the selected country or 'rest_of_world'
                    return response()->json([
                        'status' => false,
                        //                        'message' => 'Shipping information not available.', // Return an error message
                        'grandTotal' => number_format($subTotal, 2), // Just return the subtotal if no shipping info
                        'shippingCharge' => number_format(0, 2), // Shipping charge is zero
                    ]);
                }
            }
        }

        //        // If country_id is not valid, return an error response
        //        return response()->json([
        //            'status' => false,
        //            'message' => 'Invalid country ID provided.',
        //        ]);
    }
}
