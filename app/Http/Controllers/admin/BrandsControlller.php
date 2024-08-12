<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandsControlller extends Controller
{
    // Display a listing of the brands
    public function index(Request $request)
    {
        $search = $request->input('search');
        $brands = Brand::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10);

        return view('admin.brands.list', compact('brands'));
    }

    // Show the form for creating a new brand
    public function create()
    {
        return view('admin.brands.create');
    }

    // Store a newly created brand in storage
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|unique:brands,slug',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->input('name');
            $brand->slug = $request->input('slug');
            $brand->status = $request->input('status');

            $brand->save();

            return response()->json([
                'status' => true,
                'message' => 'Brand has been created successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // Show the form for editing the specified brand
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    // Update the specified brand in storage
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|unique:brands,slug,' . $brand->id,
            'status' => 'required|in:0,1',
        ]);

        if ($validator->passes()) {
            $brand->name = $request->input('name');
            $brand->slug = $request->input('slug');
            $brand->status = $request->input('status');

            $brand->save();

            return response()->json([
                'status' => true,
                'message' => 'Brand has been updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // Remove the specified brand from storage
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();

        return response()->json([
            'status' => true,
            'message' => 'Brand has been deleted successfully',
        ]);
    }
}
