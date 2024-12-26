<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function index(){
        if(!Auth::user()->hasPermissionTo('dashboard.view')){
            abort(403, 'You are not allowed to view dashboard');
        }
        return view('admin.pages.dashboard');
    }
}