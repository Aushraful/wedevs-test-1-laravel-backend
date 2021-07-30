<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }

    public function index()
    {
        return ProductCollection::collection(Product::all());
    }

    public function store(ProductRequest $productRequest)
    {
        $image    = $productRequest->file('image');
        $imageFile   = Str::slug($productRequest->title).'.'.$image->getClientOriginalExtension();

        $image = Image::make($productRequest->file('image')->getRealPath());
        $image->resize(400, 300);

        if (!file_exists('storage/images/products')) {
            mkdir('storage/images/products', 666, true);
        }

        $image->save(public_path('storage/images/products/'.$imageFile));

        $product = Product::create([
            'title'         => $productRequest->title,
            'description'   => $productRequest->description,
            'price'         => $productRequest->price,
            'image'         => $imageFile,
        ]);

        return response()->json([
            'message' => 'Product created successfully!'
        ], 201);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $productRequest, Product $product)
    {

        $product->update([
            'title'         => $productRequest->title,
            'description'   => $productRequest->description,
            'price'         => $productRequest->price,
        ]);

        if ($productRequest->hasFile('image'))
        {
            $image    = $productRequest->file('image');
            $imageFile   = Str::slug($productRequest->title).'.'.$image->getClientOriginalExtension();

            $image = Image::make($productRequest->file('image')->getRealPath());
            $image->resize(400, 300);
            $image->save(public_path('storage/images/products/'.$imageFile));

            $product->update([
                'image'         => $imageFile,
            ]);
        }

        return response()->json([
            'message' => 'Product Updated Successfully!'
        ], 200);
    }

    public function destroy(Product $product)
    {
        $toDelete = $product->image;

        // Deleting image from public/storage
        if(\File::exists(public_path('storage/images/products/'.$toDelete))){
            \File::delete(public_path('storage/images/products/'.$toDelete));
        }

        $product->delete();

        return response()->json([
            'message' => 'Deleted Successfully!'
        ], 200);
    }
}
