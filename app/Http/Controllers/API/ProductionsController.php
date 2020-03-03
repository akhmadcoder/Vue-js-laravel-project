<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Production;
use App\Product;

class ProductionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Production::with('product')->orderBy('date', 'desc')->get();
        $productNames = Product::get();

        return response()->json([
            'products' => $products,
            'productNames' => $productNames,
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
            'quantity' => 'required|numeric',
            'date' => 'required|date',
            'product_id' => 'required',
        ]);

        if(Production::create([
                'quantity' => $request['quantity'],
                'date' => $request['date'],
                'product_id' => $request['product_id'],
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
            'quantity' => 'required|numeric',
            'date' => 'required|date',
            'product_id' => 'required',
        ]);

        $product = Production::findOrFail($id);
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
        $product = Production::findOrFail($id);

        if($product->delete())
        {
            return response()->json([
                'status' => 'success'
            ]); 
        }
    }
}
