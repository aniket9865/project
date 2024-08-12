<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    // Display a listing of the subcategories
    public function index(Request $request)
    {
        $search = $request->input('search');
        $subcategories = SubCategory::leftJoin('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->select('sub_categories.*', 'categories.name as category_name')
            ->when($search, function ($query, $search) {
                return $query->where('sub_categories.name', 'like', "%{$search}%")
                    ->orWhere('categories.name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.subcategory.list', compact('subcategories'));
    }

    // Show the form for creating a new subcategory
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.subcategory.create', compact('categories')); // Pass categories to the view
    }

    // Store a newly created subcategory in storage
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|unique:sub_categories,slug',
            'category_id' => 'required',
            'status' => 'required|in:0,1',
            'showhome' => 'required|in:No,Yes', // Added showhome validation
        ]);

        if ($validator->passes()) {
            $subCategory = new SubCategory();
            $subCategory->name = $request->input('name');
            $subCategory->slug = $request->input('slug');
            $subCategory->category_id = $request->input('category_id');
            $subCategory->status = $request->input('status');
            $subCategory->showhome = $request->input('showhome'); // Save showhome

            $subCategory->save();

            return response()->json([
                'status' => true,
                'message' => 'SubCategory has been created successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // Show the form for editing the specified subcategory
    public function edit($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.subcategory.edit', compact('subCategory', 'categories'));
    }

    // Update the specified subcategory in storage
    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id,
            'category_id' => 'required',
            'status' => 'required|in:0,1',
            'showhome' => 'required|in:No,Yes', // Added showhome validation
        ]);

        if ($validator->passes()) {
            $subCategory->name = $request->input('name');
            $subCategory->slug = $request->input('slug');
            $subCategory->category_id = $request->input('category_id');
            $subCategory->status = $request->input('status');
            $subCategory->showhome = $request->input('showhome'); // Update showhome

            $subCategory->save();

            return response()->json([
                'status' => true,
                'message' => 'SubCategory has been updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // Remove the specified subcategory from storage
    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $subCategory->delete();

        return response()->json([
            'status' => true,
            'message' => 'SubCategory has been deleted successfully',
        ]);
    }
}
