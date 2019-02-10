@extends('layouts.agent-layout')

@section('content')
    <div class="container-fluid">
        <div class="row" style="margin-right: 2em;margin-left: 2em;margin-top:1em;">
            <h6 style="text-align: center;font-weight: bolder;">Your Profile Information</h6>
            <div class="card hoverable">
                <form class="col s12 ">
                    @csrf
                    <div class="row">
                        <div class="col m4">
                            <ul>
                                <li><div class="user-view">
                                        <a href="#user"><img class="circle" src="{{!is_null(\Illuminate\Support\Facades\Auth::user()->profile_picture_url)?\Illuminate\Support\Facades\Auth::user()->profile_picture_url:'/images/profile_placeholder.jpg'}}"/></a>

                                    </div></li>
                                <div class="divider"></div>
                            </ul>
                        </div>
                        <div class="col m6">
                            <div class="file-field input-field" style="bottom:0px!important;">
                                <div class="btn">
                                    <span>Change Profile Picture</span>
                                    <input type="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6">
                            <input id="name" type="text" value="{{$user->name}}" class="validate">
                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col m6">
                            <input id="surname" type="text" value="{{$user->surname}}" class="validate">
                            <label for="surname">Surname</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6">
                            <input id="email" type="email" class="validate" value="{{$user->email}}" disabled>
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col m6">
                            <input id="contact_number" type="tel" class="validate" value="{{$user->contact_number}}">
                            <label for="contact_number">Contact Number</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6">
                            <input id="job_title" type="text" class="validate" value="{{$user->job_title}}">
                            <label for="job_title">Job Title</label>
                        </div>
                        <div class="input-field col m6">
                            <input id="job_title" type="text" disabled class="validate" value="{{$user->roles[0]->display_name}}">
                            <label>System Role</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6" style="margin-left:1em;">
                            <label>Change Password</label>
                            <p>
                                <label>
                                    <input name="group1" type="radio" checked />
                                    <span>No</span>
                                </label>

                                <label>
                                    <input name="group1" type="radio" />
                                    <span>Yes</span>
                                </label>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6">
                            <input id="old_password" type="password" class="validate" value="">
                            <label for="old_password">Old Password</label>
                        </div>
                        <div class="input-field col m6">
                            <input id="new_password" type="password" class="validate" >
                            <label for="new_password">New Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6">
                            <input id="repeat_password" type="password" class="validate" value="">
                            <label for="repeat_password">Repeat Password</label>
                        </div>

                    </div>
                </form>
                <div class="row">
                    <div style="float:right;margin-bottom: 2em!important;">
                        <button class="btn waves-effect waves-light project-back" style="margin-left:2em;" >Quit
                            <i class="material-icons right">close</i>
                        </button>
                        <button class="btn waves-effect waves-light" style="margin-left:2em;margin-right: 2em;" id="save-socios" name="action">Save
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection