<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return response()->json(['users' => $users]); 
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
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        try { 
          
            if(DB::insert('insert into role_user (role_id, user_id) values (?, ?)', 
            [$request->role, $user->id])) {

                return response()->json([

                    'status' => 'success',
                    'message' => 'xaa'
                ]); 
            }
            
        } catch(\Illuminate\Database\QueryException $ex){ 

            $user->delete();
          
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
                'cod' => 400
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
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'role' => 'sometimes',
            'password' => 'sometimes|string|min:6'
        ]);


        if($request->role != ""){
            DB::table('role_user')
                ->where('user_id', $user->id)
                ->update(['role_id' => $request->role]);
        }

        try {

            $user->update($request->all());
            return response()->json([
                'status' => 'success',
            ]);
            
        } catch(\Illuminate\Database\QueryException $ex){ 

            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage(),
            ]);
        }

        

        return ['message' => 'Updated the user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        //delete the user
        try {

            DB::table('role_user')->where('user_id', $user->id)->delete();

            if($user->delete())
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
