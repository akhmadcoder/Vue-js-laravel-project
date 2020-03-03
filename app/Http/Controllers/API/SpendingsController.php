<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Spendings;
use App\Expense;
use App\Money;

class SpendingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spendings = Spendings::with(['expense', 'money'])->get();
        $expenses = Expense::get();
        $moneys = Money::get();
        
        return response()->json([
            'spendings' => $spendings,
            'expenses' => $expenses,
            'moneys' => $moneys,
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
        if($request['quantity'] == "")
        {
            $request['quantity'] = 1;
        }

        $this->validate($request,[
            'expense_id' => 'required',
            'cost' => 'required|numeric',
            'money_id' => 'required',
            'date' => 'required',
            'quantity' => 'required|numeric',
        ]);

        

        if($spending = Spendings::create([
                'expense_id' => $request['expense_id'],
                'cost' => $request['cost'],
                'money_id' => $request['money_id'],
                'description' => $request['description'],
                'date' => $request['date'],
                'quantity' => $request['quantity']
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
        if($request['quantity'] == "")
        {
            $request['quantity'] = 1;
        }

        $this->validate($request,[
            'expense_id' => 'required',
            'cost' => 'required|numeric',
            'money_id' => 'required',
            'date' => 'required',
            'quantity' => 'required|numeric',
        ]);

        $spending = Spendings::findOrFail($id);
        $spending->update($request->all());
        
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
        $spending = Spendings::findOrFail($id);

        if($spending->delete())
        {
            return response()->json([
                'status' => 'success'
            ]); 
        }
    }
}
