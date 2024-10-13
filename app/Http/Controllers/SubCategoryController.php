<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::with(['category', 'productTypes', 'products'])->get();
    
        $formattedSubcategories = $subcategories->map(function ($subcategory) {
            return [
                'id' => $subcategory->id,
                'name' => $subcategory->name,
                'category' => [
                    'id' => $subcategory->category->id,
                    'name' => $subcategory->category->name,
                ],
                'product_types' => $subcategory->productTypes->map(function ($productType) {
                    return [
                        'id' => $productType->id,
                        'name' => $productType->name,
                    ];
                }),
                'products' => $subcategory->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'featured_image' => $product->featured_image,
                    ];
                }),
            ];
        });
    
        return response()->json([
            'message' => 'All subcategories retrieved with product types and products',
            'data' => $formattedSubcategories,
            'count' => count($formattedSubcategories),
        ], 200);
    }
    

    public function store(Request $request)
    {
        $subCategory = SubCategory::create($request->all());

        return response()->json($subCategory, 201);
    }

    public function show($id)
    {
        try {
            return SubCategory::with('category', 'products')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'SubCategory not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->update($request->all());

        return response()->json($subCategory, 200);
    }

    public function destroy($id)
    {
        $sub_category = SubCategory::find($id);

        if (! $sub_category || $sub_category->user_id !== Auth::id()) {
            return response()->json(['message' => 'SubCategory not found'], 404);
        }

        $sub_category->delete();

        return response()->json(null, 204);
    }
}
