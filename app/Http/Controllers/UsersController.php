<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Location;
use App\Mail\InviteUser;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::where('name','!=','app-admin')->get();
        return view('users.index',compact('roles'));
    }


    public function getUserProfile(){
        $user = Auth::user()->load('roles');
       if($user->roles[0]->name=='app-admin'){
           return view('users.profile',compact('user'));
       }else{
           return view('users.agent-profile',compact('user'));
       }
    }

    public function updateProfile(Request $request, User $user){
        $input = $request->all();
        $temp_user = $user;
        DB::beginTransaction();
        try{
            if($request->has('profile_picture_url')) {
                $path = $request->file('profile_picture_url')->store('users');
                $user->update(['name' => $input['name'], 'surname' => $input['surname'], 'contact_number' => $input['contact_number'], 'address' => $input['address'], 'profile_picture_url' => $path]);
            }else{
                $user->update(['name' => $input['name'], 'surname' => $input['surname'], 'contact_number' => $input['contact_number'], 'address' => $input['address']]);

            }
            DB::commit();
            $user = $temp_user->fresh();
            return response()->json(['message'=>'Your profile has been updated successfully','user'=>$user],200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'An error occured while trying to update your profile '.$e->getMessage()],500);
        }
    }

    public function getUsers(){
        $users = User::whereHas('roles',function($query){
            $query->where('name','agent');
            return $query;
        })->get();
        $users->load('roles','location');

        return Datatables::of($users)->addColumn('action', function ($user) {
            $re = '/update-user/' . $user->id;
            $sh = '/user/show/' . $user->id;
            $del = '/user/delete/' . $user->id;
            return '<a href=' . $re . ' title="Edit User"><i class="material-icons">create</i></a><a href=' . $del . ' title="Delete" style="color:red"><i class="material-icons">delete_forever</i></a>';
        })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::where('name','!=','app-admin')->get();
        $locations = Location::orderBy('location_name','asc')->get();

        return view('users.create-user',compact('roles','locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        //
        $input = $request->validated();
        DB::beginTransaction();
        try{
            $user = User::create(['name'=>$input['name'],'location_id'=>$input['location_id'],'surname'=>$input['surname'],'contact_number'=>$input['contact_number'],'address'=>$input['address'],'email'=>$input['email'],'password'=>Hash::make('secret')]);
            $role = Role::where('name','agent')->first();
            $user->roles()->attach($role->id);
            $user = $user->load('roles');

            $verification_url = url('account-completion/'.$user->id);
            Mail::to($user)->send(new InviteUser($user,$verification_url));
            DB::commit();

            DB::commit();
            return response()->json(['user'=>$user,'message'=>'User created successfully and an email has been sent for account activation'],200);

        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'User could not be saved at the moment ' . $e->getMessage()], 400);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $agent)
    {
        //
        $locations = Location::orderBy('location_name','asc')->get();
        return view('users.agent-edit',compact('agent','locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $agent)
    {
        //
        $input = $request->all();
        DB::beginTransaction();
        try{
            $agent->update(['name'=>$input['name'],'location_id'=>$input['location_id'],'surname'=>$input['surname'],'contact_number'=>$input['contact_number'],'address'=>$input['address'],'email'=>$input['email'],'password'=>Hash::make('secret')]);
             DB::commit();
            return response()->json(['message'=>'User updated successfully'],200);

        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'User could not be updated at the moment ' . $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return redirect('users');

    }
}
