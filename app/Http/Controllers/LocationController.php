<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationStoreRequest;
use App\Location;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('locations.index');
    }

    public function getLocations(){
        $locations = Location::orderBy('location_name','asc')->get();

        return Datatables::of($locations)->addColumn('action', function ($location) {
            $re = '/locations/' . $location->id.'/edit';
            $sh = '/location/show/' . $location->id;
            $del = '/location/delete/' . $location->id;
            return '<a style="color:green;" href=' . $re . ' title="Edit Location"><i class="material-icons">create</i></a><a href=' . $del . ' title="Delete Location" style="color:red"><i class="material-icons">delete_forever</i></a>';
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        //
        DB::beginTransaction();
        try{
            $input = $request->validated();
            $location = Location::create(['location_name'=>$input['location_name'],'city'=>$input['city'],'description'=>$input['description']]);
            DB::commit();
            return response()->json(['message'=>'Location saved successfully','location'=>$location],200);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'An error occured, please contact your IT admin '.$e->getMessage()],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
        return view('locations.edit',compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(LocationStoreRequest $request, Location $location)
    {
        //
        DB::beginTransaction();
        try{
            $input = $request->validated();
            $location->update(['location_name'=>$input['location_name'],'city'=>$input['city'],'description'=>$input['description']]);
            DB::commit();
            return response()->json(['message'=>'Location updated successfully','location'=>$location],200);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'An error occured while updating location, please contact your IT admin '.$e->getMessage()],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //

        DB::beginTransaction();
        try{
            $location->delete();
            DB::commit();
            return redirect('locations');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('locations');
        }
    }
}
