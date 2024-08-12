<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Display a listing of the orders.
    public function index()
    {
        $orders = Order::all();
        return view('admin.order.list', compact('orders'));
    }

    // Show the form for creating a new order.
    public function create()
    {
        return view('admin.order.detail');
    }

    // Store a newly created order in the database.
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $order = new Order([
            'customer_name' => $request->get('customer_name'),
            'product_name' => $request->get('product_name'),
            'quantity' => $request->get('quantity'),
            'price' => $request->get('price'),
        ]);

        $order->save();

        return redirect()->route('order.list')->with('success', 'Order created successfully.');
    }

    // Show the form for editing the specified order.
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.edit', compact('order'));
    }

    // Update the specified order in the database.
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $order = Order::findOrFail($id);
        $order->customer_name = $request->get('customer_name');
        $order->product_name = $request->get('product_name');
        $order->quantity = $request->get('quantity');
        $order->price = $request->get('price');

        $order->save();

        return redirect()->route('order.list')->with('success', 'Order updated successfully.');
    }

    // Remove the specified order from the database.
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('order.list')->with('success', 'Order deleted successfully.');
    }
}
