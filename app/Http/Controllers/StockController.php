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
            return '<a href=' . $del . ' title="View Assigned Stock" style="color:blue;margin-right: 2em;"><i class="material-icons">remove_red_eye</i></a><a href=' . $re . ' title="Assign Agent Stock" style="color:green;"><i class="material-icons">assignment_turned_in</i></a>';
        })
            ->make(true);
    }

    public function viewAssignedStock(User $agent){

        return view('stock.view-assigned-stock',compact('agent'));
    }

    public function getViewAssignedStock(User $agent){
        $products = $agent->assigned_stock;
        $products->load('product_category');

        $total_sum = 0;
        foreach ($products as $product){
            $total_sum += round($product->pivot->product_quantity*$product->price,4);
            $product->total_value = number_format($total_sum,2);
        }

        return Datatables::of($products)->addColumn('action', function ($product) {
            $re = '/assign-agent-stock/' . $product->id;
            $del = '/view-assigned-stock/' . $product->id;
            return '<a href=' . $del . ' title="Un-Assign Stock" style="color:red;margin-right: 2em;"><i class="material-icons">backspace</i></a>';
        })->make(true);
    }


    public function getAgentAssignedStock(User $agent){
        $agent_assigned_stock = $agent->assigned_stock()->pluck('product_id');

        $products = Product::with('product_category')
                    ->whereNotIn('products.id',$agent_assigned_stock)
                    ->orderBy('product_name','asc')->get();
        return Datatables::of($products)->addColumn('action', function ($product) {
            return '<input type="checkbox" class="check" id='.$product->id.' value='.$product->id.' name='.$product->product_name.' />';
//            return '<a href=' . $re . ' title="Assign Agent Stock" style="color:green;margin-right: 2em;"><i class="material-icons">assignment_turned_in</i></a><a href=' . $del . ' title="View Assigned Stock" style="color:blue"><i class="material-icons">remove_red_eye</i></a>';
        })
            ->make(true);
    }

    public function assignAgentStock(User $agent){
        $agent_assigned_stock = $agent->assigned_stock()->pluck('product_id');

        $products = Product::with('product_category')
            ->whereNotIn('products.id',$agent_assigned_stock)
            ->orderBy('product_name','asc')->get();

        return view('stock.stock-assignment',compact('agent','products'));
    }

    public function saveAssignedStock(Request $request){
        DB::beginTransaction();
        try{
            $input = $request->all();
            $products = json_decode($input['assigned_products']);
            foreach ($products as $product){
                $user = User::find($product->user_id);
                $cur_prod = Product::find($product->product_id);
                $cur_prod->quantity -= $product->quantity;
                $cur_prod->save();
                $user->assigned_stock()->save($cur_prod,['product_quantity'=>$product->quantity]);
            }
            DB::commit();
            return response()->json(['message'=>'Stock successfully assigned to agent','returnee'=>$products,'input'=>$input],200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'An error occured during saving Agent stock. '.$e->getMessage()],500);
        }
    }


}
