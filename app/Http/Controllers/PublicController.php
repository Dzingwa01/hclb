<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PublicController extends Controller
{
    //
    public function accountCompletion(User $user){
        return view('users.account-completion',compact('user'));

    }

    public function verifyAccount(Request $request,User $user){

        DB::beginTransaction();
        $input = $request->all();
        try{
            $user->update(['email_verified_at'=>Carbon::now(),'password'=>Hash::make($input['password'])]);
            DB::commit();
            return redirect('login');
        }catch (\Exception $e){
            DB::rollBack();
        }
    }
}
