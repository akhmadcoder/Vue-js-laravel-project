<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DemoController extends Controller
{
    public function userDemo()
    {
    	return view('user');
    }

    public function adminDemo()
    {
    	$userRoles = Auth::user()->roles->pluck('name');

        if(!$userRoles->contains('admin')){
            return redirect('/permission-denied');
        }

    	return view('admin');
    }

    public function superadminDemo()
    {
    	$userRoles = Auth::user()->roles->pluck('name');

        if(!$userRoles->contains('superadmin')){
            return redirect('/permission-denied');
        }
        
    	return view('superadmin');
    }

    public function permissionDeied()
    {
    	return view('nopermission');
    }
}
