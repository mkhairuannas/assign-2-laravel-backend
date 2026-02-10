<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    // GET /api/products -> List all products
    public function index(){
        $products = Product::all();
        return response()->json($products, 200);
    }
    // POST /api/products -> Create new product
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required|string|max:255',
            'price'=> 'required|numeric',
            'stock'=> 'required|integer'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }
    
    // GET /api/products/{id} -> View single product
    public function show($id){
        $product = Product::find($id);

        if(!$product){
            return response()->json(['message'=>'Product not found'],404);
        }
        return response()->json($product,200);
    }

    // PUT /api/products/{id} -> Update a product
    public function update(Request $request, $id){
        $product = Product::find($id);

        if (!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product->update($request->all());
        return response()->json($product, 200);    
    }

    // DELETE /api/products/{id} -> Delete a product
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
