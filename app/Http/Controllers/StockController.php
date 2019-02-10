<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('stock.assign-stock');
    }

    public function getAgents(){

        $users = User::whereHas('roles',function($query){
            $query->where('name','agent');
            return $query;
        })->get();
        $users->load('location');

        return Datatables::of($users)->addColumn('action', function ($user) {
            $re = '/assign-agent-stock/' . $user->id;
            $del = '/view-assigned-stock/' . $user->id;
            return '<a href=' . $re . ' title="Assign Agent Stock" style="color:green;margin-right: 2em;"><i class="material-icons">assignment_turned_in</i></a><a href=' . $del . ' title="View Assigned Stock" style="color:blue"><i class="material-icons">remove_red_eye</i></a>';
        })
            ->make(true);
    }

    public function assignAgentStock(User $agent){
        $products = Product::orderBy('product_name','asc')->get();

        return view('stock.stock-assignment',compact('agent','products'));
    }

}
