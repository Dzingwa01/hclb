<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>HLCB</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{--<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>--}}
    <link href="/css/site-styles.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    {{--<link href="//cdn.datatables.net/responsive/2.2.3/css/dataTables.responsive.css" rel="stylesheet"/>--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"/>
    {{--<link href="/css/jquery-step-maker.css" type="text/css" rel="stylesheet" media="screen,projection"/>--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Compiled and minified JavaScript -->
</head>
<body>

<div class="navbar-fixed">
    <nav class="white" role="navigation" style="height: 5em;">
        <div class="nav-wrapper">
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <a id="logo-container" href="{{url('/home')}}" class="brand-logo center">HLCB
            </a>
            <ul class="right hide-on-med-and-down">
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Account<i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>

        </div>

    </nav>
    <ul id="dropdown1" class="dropdown-content">
        <li><a href="{{url('user-profile')}}">Profile</a></li>
        <li><a style="color:black;" href="{{ url('/logout') }}" class=""
               onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Sign Out
            </a></li>
    </ul>
    <ul id="slide-out" class="sidenav ">
        <li><div class="user-view">
                <a href="#user"><img class="circle" src="{{!is_null(\Illuminate\Support\Facades\Auth::user()->profile_picture_url)?'/storage/'.\Illuminate\Support\Facades\Auth::user()->profile_picture_url:'/img/profile_placeholder.jpg'}}"/></a>
                <a href="#name"><span class="name" style="color:black;font-weight: bolder">{{\Illuminate\Support\Facades\Auth::user()->name . " ".\Illuminate\Support\Facades\Auth::user()->surname}}</span></a>
                <a href="#email"><span class="email" style="color:black;font-weight: bolder">{{\Illuminate\Support\Facades\Auth::user()->roles[0]->display_name}}</span></a>

            </div></li>
        <div class="divider"></div>

        <ul class="collapsible popout" style="margin-top:1em;" onclick="dashboard_show()">
            <li>
                <div class="collapsible-header" style="color:black;font-weight: bolder"> <i class="tiny material-icons">home</i><a href="/home" class="" style="color:black;"> Home</a>
                </div>
                <div class="collapsible-body" >
                </div>
            </li>
        </ul>
        <ul class="collapsible popout" style="margin-top:1em;">
            <li>
                <div class="collapsible-header" style="color:black;font-weight: bolder"> <i class="tiny material-icons">account_balance</i>
                    Reporting </div>
                <div class="collapsible-body" >
                    <ul>

                    </ul>
                </div>
            </li>
        </ul>
        <ul class="collapsible popout" style="margin-top:1em;">
            <li>
                <div class="collapsible-header" style="color:black;font-weight: bolder"> <i class="tiny material-icons">add_shopping_cart</i>
                   Manage Stock </div>
                <div class="collapsible-body" >
                    <ul>
                        <li><a style="color:black;font-weight: bolder" class="" href="#"><i
                                        class="tiny material-icons">add_to_queue</i>Assigned Stock</a></li>
                        {{--<li><a style="color:black;font-weight: bolder" class="" href="{{url('get-assigned-stock/'.$user->id)}}"><i--}}
                                        {{--class="tiny material-icons">add_to_queue</i>Assigned Stock</a></li>--}}
                        {{--<li><a style="color:black;font-weight: bolder" class="" href="{{url('roles')}}"><i--}}
                                        {{--class="tiny material-icons">assignment</i>Agent Stock</a></li>--}}

                    </ul>
                </div>
            </li>
        </ul>


        <div class="divider"></div>
        <ul class="collapsible popout" style="margin-top:1em;">
            <li>
                <div class="collapsible-header" style="color:black;font-weight: bolder"> <i class="tiny material-icons">account_circle</i><a href="/agent-profile" class="" style="color:black;"> Profile</a>
                </div>
                <div class="collapsible-body" >
                </div>
            </li>
        </ul>
        <ul class="collapsible popout" style="margin-top:1em;">
            <li>
                <div class="collapsible-header" style="color:black;font-weight: bolder"   onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <a style="color:black;" href="{{ url('/logout') }}" class=""
                    ><i
                                class="tiny material-icons">vpn_key</i>
                        Sign Out
                    </a>
                </div>
                <div class="collapsible-body" >
                </div>
            </li>
        </ul>

    </ul>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
<div class="container-fluid">
    @yield('content')
</div>

</div>
<style>
    .sidenav-overlay {
        z-index: 996;
    }

    @media only screen and (min-width: 993px) {
        nav a.sidenav-trigger {
            display: inline;
        }
    }
    nav a{
        color:black!important;
        font-weight: bolder!important;
    }

</style>
<!--  Scripts-->
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
{{--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">--}}
{{--<script type="text/javascript" charset="utf8"--}}
{{--src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>--}}

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
{{--<script src="/js/jquery-step-maker.js"></script>--}}
<script>
    let options = {
        format:'yyyy-mm-dd'
    }
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.datepicker');
        var instances = M.Datepicker.init(elems, options);
    });
    $(document).ready(function () {
        console.log("initializing");
        $('input.autocomplete').autocomplete({
            data: {
                "Apple": null,
                "Microsoft": null,
                "Google": 'https://placehold.it/250x250'
            },
        });
        $('.collapsible').collapsible();
        $('.sidenav').sidenav();
        $(".dropdown-trigger").dropdown();
        $('.carousel').carousel();
        $('.tabs').tabs();
        $('.modal').modal();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    function dashboard_show(){
        window.location.href = '/home';
    }

    function reports_show(){

    }

</script>
@stack('custom-scripts')
</body>
</html>
