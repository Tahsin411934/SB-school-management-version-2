<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
class TransactionController extends Controller
{
    //
    public function store($id)
    {
        $user = Auth::user();
        
        $obj =new Transaction();
        $obj->user_id = $user->id;
        $obj->product_id = $id;
        $obj-> save();
        return redirect('/dashboard');
    }

    public function getAllTransactions(){
        if(!Auth::user()->hasPermissionTo('transaction.view')){
            abort(403, 'You are not allowed to view transaction');
        }
        $transactions = Transaction::with(['user', 'product'])->get();
        return view('admin.pages.transaction.all', compact('transactions'));
    }

    // Show specific user transactions 
    // public function userTransactions()
    // {
    //     $user = Auth::user();
    //     $transactions = Transaction::where('user_id', $user->id)->with('product')->get();
    //     return view('dashboard', compact('transactions'));
    // }
}