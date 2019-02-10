@extends('layouts.admin-layout')

@section('content')

    <div class="row" style="margin-top:2em;">
        <h4 class="center">Dashboard</h4>
        <div class="col s12 m4">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title" style="font-weight: bolder">Total Sales Per Month</span>

                </div>
                <div class="card-action">
                    <a href="{{url('users')}}">View Sales Details</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title" style="font-weight: bolder">Number of Agents Per Area</span>

                </div>
                <div class="card-action">
                    <a href="#">View Agents</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title" style="font-weight: bolder">Products Sold</span>

                </div>
                <div class="card-action">
                    <a href="#">View Products</a>
                </div>
            </div>
        </div>
    </div>

@endsection
