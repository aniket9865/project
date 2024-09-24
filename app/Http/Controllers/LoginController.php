<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Show login form
    public function index()
    {
        return view('login');
    }

// Process login
    public function authenticate(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // If validation fails, redirect back with input and errors
        if ($validator->fails()) {
            return redirect()->route('account.login')
                ->withInput()
                ->withErrors($validator);
        }

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Fetch the authenticated user
            $user = Auth::user();

            // Check if the user's role is 'customer'
            if ($user->role === 'customer') {
                // Authentication successful, and role is 'customer', redirect to the dashboard
//                return redirect()->route('account.dashboard');
                return redirect()->route('front.checkout');
            } else {
                // Role is not 'customer', log out and redirect back with error
                Auth::logout();
                return redirect()->route('account.login')
                    ->with('error', 'You do not have the necessary permissions to access this area');
            }
        } else {
            // Authentication attempt failed, redirect back with error
            return redirect()->route('account.login')
                ->with('error', 'Email or Password is Incorrect');
        }
    }

// Show registration form
    public function register()
    {
        return view('register');
    }

// Process registration
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')
                ->withInput()
                ->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'customer'; // Assuming 'customer' is a string, adjust according to your role management
        $user->save();

        return redirect()->route('account.login')->with('success', 'Registration Successful');
    }

// Log out user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'You have been logged out');
    }


    public  function account()
    {
        return view('front.account');
    }
    public function orders(){
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();

        return view('front.order', compact('orders'));
    }

//    public function orderDetail($id)
//    {
//        $data = [];
//        $user = Auth::user();  // Fixed missing `=`
//        $order = Order::where('user_id', $user->id)->where('id', $id)->first();  // Fixed `$order` assignment
//        $data['order'] = $order;  // Fixed missing `=` and corrected `$data` array
//        $orderItems = OrderItem::where('order_id', $id)->get();  // Fixed `$orderItems` assignment
//        $data['orderItems'] = $orderItems;  // Fixed syntax in `$data` array key
//
//        $orderItemsCount = OrderItem::where('order_id', $id)->count();
//        $data['orderItemsCount'] = $orderItemsCount;
//
//        return view('front.order_detail', $data);  // Corrected return statement to pass `$data`
//    }

    public function orderDetail($id)
    {
        $data = [];
        $user = Auth::user();

        // Retrieve the order
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }

        $data['order'] = $order;

        // Retrieve order items
        $orderItems = OrderItem::where('order_id', $id)->get();
        $data['orderItems'] = $orderItems;

        // Count the number of order items
        $orderItemsCount = OrderItem::where('order_id', $id)->count();
        $data['orderItemsCount'] = $orderItemsCount;

        return view('front.order_detail', $data);
    }


}

