<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\RawMaterials;
use App\Calculation;


class CalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('producttypes')->get();
        $rawMaterials = RawMaterials::get();

        return response()->json([
            'products' => $products,
            'rawMaterials' => $rawMaterials,
        ]);
    }

    public function getSingleProductRawMaterials($id)
    {
        $materials = Calculation::where('product_id', $id)->with('rawmaterials')->get(); 
        return response()->json(['materials' => $materials ]);

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
            'quantity' => 'required|numeric|between:0,99.99',
            'raw_materials_id' => 'required',
        ]);
        
        // check if already added
        $exist = Calculation::where('raw_materials_id', $request['raw_materials_id'])
                                ->where('product_id', $request['product_id'])
                                ->get();

        if(count($exist)>0)
        {
            return response()->json(['status' => 'error']);
        } 

        if(Calculation::create([
                'quantity' => $request['quantity'],
                'raw_materials_id' => $request['raw_materials_id'],
                'product_id' => $request['product_id']
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $singleRawMaterial = Calculation::findOrFail($id);

        if($singleRawMaterial->delete())
        {
            return response()->json([
                'status' => 'success'
            ]); 
        }
    }
}
