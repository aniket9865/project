<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Display a listing of the orders.
    public function index(Request $request) {
        // Get orders with users' data
        $orders = Order::latest('orders.created_at')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'users.name', 'users.email');

        // Check for search keyword
        if ($request->get('search') != "") {
            $keyword = $request->search;
            $orders = $orders->where(function($query) use ($keyword) {
                $query->where('users.name', 'like', '%' . $keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $keyword . '%')
                    ->orWhere('orders.id', 'like', '%' . $keyword . '%')
                    ->orWhere('orders.mobile', 'like', '%' . $keyword . '%');;
            });
        }

        // Paginate results and append query parameters
        $orders = $orders->paginate(10)->appends($request->query());

        // Return view with orders data
        return view('admin.order.list', ['orders' => $orders]);
    }

    public function detail($orderId) {
        // Fetch the order with country name
        $order = Order::select('orders.*', 'countries.name as countryName')
            ->where('orders.id', $orderId)
            ->leftJoin('countries', 'countries.id', '=', 'orders.country_id')
            ->first();

        // Fetch the order items
        $orderItems = OrderItem::where('order_id', $orderId)->get();

        // Return the view with order and order items
        return view('admin.order.detail', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }

    public function changeOrderStatus(Request $request, $orderId)
    {
        // Find the order by its ID
        $order = Order::find($orderId);

        // Check if the order exists
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Update the order status and shipped date
        $order->status = $request->input('status');
        $order->shipped_date = $request->input('shipped_date');
        $order->save();

        // Prepare the success message
        $message = 'Order status updated successfully';

        // Flash the success message to the session
        session()->flash('success', $message);

        // Return the JSON response
//        return response()->json([
//            'status' => true,
//            'message' => $message
//        ]);
        return redirect()->route('orders.index')->with('message', $message);

    }


}
