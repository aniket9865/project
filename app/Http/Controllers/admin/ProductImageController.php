<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        $paths = [];

        foreach ($request->file('images') as $file) {
            $path = $file->store('uploads/products', 'public');
            $paths[] = $path;
        }

        return response()->json(['image_paths' => $paths]);
    }

    public function destroy(Request $request)
    {
        $path = $request->input('image_path');

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'Image deleted successfully.']);
        }

        return response()->json(['message' => 'Image not found.'], 404);
    }
}
