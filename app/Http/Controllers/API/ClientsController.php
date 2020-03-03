<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\ClientCategory;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::with('categories')->get();
        $categories = ClientCategory::get();
        
        return response()->json([
            'clients' => $clients,
            'categories' => $categories,
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
            'name' => 'required|string|max:45',
            'description' => 'sometimes',
            'client_category_id' => 'required',
        ]);

        try {

            if($client = Client::create([
                'name' => $request['name'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'description' => $request['description'],
                'client_category_id' => $request['client_category_id'],
                ])){
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
        $client = Client::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:45',
            'description' => 'sometimes',
            'client_category_id' => 'required',
        ]);

        $client->update($request->all());
        
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
        $client = Client::findOrFail($id);

        //delete the user
        try {

            if($client->delete())
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
}
