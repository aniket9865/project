<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    // Display a listing of the shipping charges
    public function index(Request $request)
    {
        $search = $request->input('search');
        $shippingCharges = ShippingCharge::with('country')
            ->when($search, fn($query, $search) =>
            $query->whereHas('country', fn($query) =>
            $query->where('name', 'like', "%{$search}%")
            )
            )
            ->latest()
            ->paginate(10);

        return view('admin.shipping.list', compact('shippingCharges'));
    }

    // Show the form for creating a new shipping charge
    public function create()
    {
        $countries = Country::all();
        return view('admin.shipping.create', compact('countries'));
    }

    // Store a newly created shipping charge in storage
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|exists:countries,id',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        if (ShippingCharge::where('country_id', $request->country)->exists()) {
            return response()->json([
                'status' => false,
                'errors' => ['country' => ['A shipping charge for this country already exists.']],
            ]);
        }

        ShippingCharge::create([
            'country_id' => $request->country,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Shipping charge has been created successfully',
        ]);
    }

    // Show the form for editing the specified shipping charge
    public function edit($id)
    {
        $shippingCharge = ShippingCharge::findOrFail($id);
        $countries = Country::all();
        return view('admin.shipping.edit', compact('shippingCharge', 'countries'));
    }

    // Update the specified shipping charge in storage
    public function update(Request $request, $id)
    {
        $shipping = ShippingCharge::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'country' => 'required|exists:countries,id',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // Check for duplicate shipping charge in another record
        if (ShippingCharge::where('country_id', $request->country)
            ->where('id', '<>', $id)
            ->exists()) {
            return response()->json([
                'status' => false,
                'errors' => ['country' => ['A shipping charge for this country already exists.']],
            ]);
        }

        $shipping->update([
            'country_id' => $request->country,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Shipping charge has been updated successfully',
        ]);
    }

    // Remove the specified shipping charge from storage
    public function destroy($id)
    {
        ShippingCharge::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Shipping charge has been deleted successfully',
        ]);
    }
}
