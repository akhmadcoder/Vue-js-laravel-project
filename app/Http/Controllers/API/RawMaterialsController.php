<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RawMaterials;
use App\Measure;

class RawMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rawmaterials = RawMaterials::with('measure')->get();
        $measures = Measure::get();

        return response()->json([
            'rawmaterials' => $rawmaterials,
            'measures' => $measures,
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
            'name' => 'required|max:55',
            'measure_id' => 'required',
        ]);

        if($rawmaterial = RawMaterials::create([
                'name' => $request['name'],
                'measure_id' => $request['measure_id'],
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
            'name' => 'required|max:55',
            'measure_id' => 'required',
        ]);

        $rawmaterial = RawMaterials::findOrFail($id);
        $rawmaterial->update($request->all());
        
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
        $rawmaterial = RawMaterials::findOrFail($id);

        if($rawmaterial->delete())
        {
            return response()->json([
                'status' => 'success'
            ]); 
        }
    }
}
