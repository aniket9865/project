<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TempImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('uploads/temp'), $imageName);

        return response()->json(['image_path' => $imageName]);
    }

    public function delete(Request $request)
    {
        $imagePath = $request->get('image_path');
        $fullImagePath = public_path('uploads/temp') . '/' . $imagePath;

        if (File::exists($fullImagePath)) {
            File::delete($fullImagePath);
            return response()->json(['status' => 'success', 'message' => 'Image deleted successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Image not found'], 404);
    }
}
