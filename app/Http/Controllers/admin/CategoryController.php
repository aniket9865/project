<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
// Display a listing of the categories
public function index(Request $request)
{
$search = $request->input('search');
$categories = Category::when($search, function ($query, $search) {
return $query->where('name', 'like', "%{$search}%");
})->latest()->paginate(10);

return view('admin.category.list', compact('categories'));
}

// Show the form for creating a new category
public function create()
{
return view('admin.category.create');
}

// Store a newly created category in storage
public function store(Request $request)
{
$validator = Validator::make($request->all(), [
'name' => 'required|max:255',
'slug' => 'required|unique:categories,slug',
'status' => 'required|in:0,1',
'showhome' => 'required|in:No,Yes',
'image' => 'nullable',
]);

if ($validator->passes()) {
$category = new Category();
$category->name = $request->input('name');
$category->slug = $request->input('slug');
$category->status = $request->input('status');
$category->showhome = $request->input('showhome');
$category->image = $request->input('image');

$category->save();

return response()->json([
'status' => true,
'message' => 'Category has been created successfully',
]);
} else {
return response()->json([
'status' => false,
'errors' => $validator->errors()
]);
}
}

// Show the form for editing the specified category
public function edit($id)
{
$category = Category::findOrFail($id);
return view('admin.category.edit', compact('category'));
}

// Update the specified category in storage
public function update(Request $request, $id)
{
$category = Category::findOrFail($id);

$validator = Validator::make($request->all(), [
'name' => 'required|max:255',
'slug' => 'required|unique:categories,slug,' . $category->id,
'status' => 'required|in:0,1',
'showhome' => 'required|in:No,Yes',
'image' => 'nullable|string',
]);

if ($validator->passes()) {
$category->name = $request->input('name');
$category->slug = $request->input('slug');
$category->status = $request->input('status');
$category->showhome = $request->input('showhome');
$category->image = $request->input('image');

$category->save();

return response()->json([
'status' => true,
'message' => 'Category has been updated successfully',
]);
} else {
return response()->json([
'status' => false,
'errors' => $validator->errors()
]);
}
}

// Remove the specified category from storage
public function destroy($id)
{
$category = Category::findOrFail($id);

// Delete the category image if it exists
if ($category->image) {
$imagePath = public_path('uploads/categories/' . $category->image);
if (file_exists($imagePath)) {
unlink($imagePath);
}
}

$category->delete();

return response()->json([
'status' => true,
'message' => 'Category has been deleted successfully',
]);
}
}
