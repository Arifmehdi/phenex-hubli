<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource; // Import ProductResource
use App\Http\Resources\ProductOverviewResource; // Import ProductOverviewResource
use App\Http\Resources\ProductWithoutDescriptionResource; // Import ProductWithoutDescriptionResource
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Import Validator

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = Product::with(['addedBy', 'categories'])->paginate(10); // Example with pagination and eager loading
        return ProductResource::collection($products);
    }

    /**
     * Display a listing of all products without descriptions.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexWithoutDescription()
    {
        $products = Product::with(['addedBy', 'categories'])->paginate(10); // Fetch all products with eager loading
        return ProductWithoutDescriptionResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ProductResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::create($request->all()); // Ensure fillable properties are set in Product model

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \App\Http\Resources\ProductResource
     */
    public function show(Product $product)
    {
        $product->load(['addedBy', 'categories']); // Eager load relationships for a single product
        return new ProductResource($product);
    }

    /**
     * Display a minimal overview of the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \App\Http\Resources\ProductOverviewResource
     */
    public function overview(Product $product)
    {
        return new ProductOverviewResource($product);
    }

    /**
     * Display product details without descriptions.
     *
     * @param  \App\Models\Product  $product
     * @return \App\Http\Resources\ProductWithoutDescriptionResource
     */
    public function withoutDescription(Product $product)
    {
        return new ProductWithoutDescriptionResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \App\Http\Resources\ProductResource|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->update($request->all());

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 204);
    }
}
