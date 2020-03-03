<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Measure;
use App\ClientCategory;

class SozlamalarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $measures = Measure::get();
        return response()->json(['measures' => $measures]); 
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
            'name' => 'required|string|max:45',
        ]);

        try {

            if($measure = Measure::create(['name' => $request['name']])){
                return response()->json(['status' => 'success']); 
            }
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
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
        $measure = Measure::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:45',
        ]);


        try {

            $measure->update($request->all());
            return response()->json([
                'status' => 'success'
            ]);
            
        } catch(\Illuminate\Database\QueryException $ex){ 

            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $measure = Measure::findOrFail($id);

        //delete the user
        try {

            if($measure->delete())
            {
                return response()->json([
                    'status' => 'success',
                ]); 
            }
            
        } catch(\Illuminate\Database\QueryException $ex){ 

            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
                'cod' => 400
            ]);
        }
    }

    // all functions with Client turlarini starts here
    public function getClientCategory()
    {
        $categories = ClientCategory::get();
        
        return response()->json([
            'categories' => $categories,
        ]); 
    }

    public function updateClientCategory(Request $request)
    {
        $category = ClientCategory::findOrFail($request->id);

        $this->validate($request,[
            'name' => 'required|string|max:45',
        ]);

        try {

            $category->update($request->all());
            return response()->json([
                'status' => 'success'
            ]);
            
        } catch(\Illuminate\Database\QueryException $ex){ 

            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ]);
        }
    }


    public function addClientCategory(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:45',
        ]);

        try {

            if($newCategory = ClientCategory::create(['name' => $request['name']])){
                return response()->json(['status' => 'success']); 
            }
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteClientCategory(Request $request)
    {
        $category = ClientCategory::findOrFail($request->id);

        //delete category
        try {

            if($category->delete())
            {
                return response()->json([
                    'status' => 'success',
                ]); 
            }
            
        } catch(\Illuminate\Database\QueryException $ex){ 

            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
                'cod' => 400
            ]);
        }
    }




    // all functions with Client turlarini ends here
}
