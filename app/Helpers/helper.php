<?php

use App\Models\Category;
use App\Models\Product;
function getCategories()
{
    return Category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->orderBy('id','DESC')
        ->where('status', 1)
        ->where('showhome','Yes')
        ->get();
}

//function getProductImage(int $productId): ?Product
//{
//    return Product::where('product_id', $productId)->first();
//}

//function getProductImage(?int $productId): ?Product
//{
//    if ($productId === null) {
//        // Handle the case where $productId is null
//        return null;
//    }
//
//    return Product::where('id', $productId)->first(); // Adjust 'id' to your actual column name
//}

function getProductImage($productId) {
    // Example of how you might handle this
    $product = Product::find($productId);
    return $product ? $product : null;
}
