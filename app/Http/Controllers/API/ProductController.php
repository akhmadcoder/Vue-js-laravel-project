<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\ProductTypes;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('producttypes')->get();
        $producttypes = ProductTypes::get();

        return response()->json([
            'products' => $products,
            'producttypes' => $producttypes,
        ]);
    }

    public function getProductByType($id)
    {
        $products = Product::where('product_types_id', $id)->with('producttypes')->get();
        $producttypes = ProductTypes::get();

        return response()->json([
            'products' => $products,
            'producttypes' => $producttypes,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:100',
            'product_types_id' => 'required',
        ]);

        if(Product::create([
                'name' => $request['name'],
                'product_types_id' => $request['product_types_id'],
        ])){
                return response()->json(['status' => 'success']); 
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|max:100',
            'product_types_id' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());
        
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if($product->delete())
        {
            return response()->json([
                'status' => 'success'
            ]); 
        }
    }
}
