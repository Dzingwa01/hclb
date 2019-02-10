@extends('layouts.admin-layout')

@section('content')
    <div class="container">
        <div class="row" style="margin-right: 2em;margin-left: 2em;margin-top:1em;">

            <div class="card hoverable">

                <form class="col s12 " style="margin-top:2em;">
                    <h6 style="text-align: center;font-weight: bolder;">Your Profile Information</h6>
                    @csrf
                    <div class="row">
                        <div class="col m3 s12">
                            <ul>
                                <li>
                                    <div class="user-view">
                                        <a href="#!"><img id="previewing" style="width: 180px;height: 180px;" class="circle" src="{{!is_null(\Illuminate\Support\Facades\Auth::user()->profile_picture_url)?'/storage/'.\Illuminate\Support\Facades\Auth::user()->profile_picture_url:'/img/profile_placeholder.jpg'}}"/></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col m7">
                            <div style="margin-top:5em;">
                                <img src="" id="previewing">
                                <div class="file-field input-field" style="bottom:0px!important;">
                                    <div class="btn">
                                        <span>Change Profile Picture</span>
                                        <input id="profile_picture_url" type="file">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                    <span id="message"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m6">
                            <input id="name" required type="text" value="{{$user->name}}" class="validate">
                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col m6">
                            <input id="surname" required type="text" value="{{$user->surname}}" class="validate">
                            <label for="surname">Surname</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6">
                            <input id="email" required type="email" class="validate" value="{{$user->email}}" disabled>
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col m6">
                            <input id="contact_number" required type="tel" class="validate" value="{{$user->contact_number}}">
                            <label for="contact_number">Contact Number</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6">
                            <textarea id="address" required class="materialize-textarea">{{$user->address}}</textarea>
                            <label for="address">Address</label>
                        </div>
                        {{--<div class="input-field col m6">--}}
                            {{--<input id="role_id" type="text" disabled class="validate" value="{{$user->roles[0]->display_name}}">--}}
                            {{--<label>System Role</label>--}}
                        {{--</div>--}}
                    </div>

                </form>
                <div class="row">
                    <div style="margin-bottom: 2em!important;" class="col offset-m4">
                        <button class="btn waves-effect waves-light profile-back" style="margin-left:2em;" >Cancel
                            <i class="material-icons right">close</i>
                        </button>
                        <button class="btn waves-effect waves-light" style="margin-left:2em;margin-right: 2em;" id="update-profile" name="action">Save
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>
        $(document).ready(function () {

            $('.profile-back').on('click',function(){
                window.history.back();
            });

            $(function () {
                $("#profile_picture_url").change(function () {
                    $("#message").empty(); // To remove the previous error message
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match = ["image/jpeg", "image/png", "image/jpg"];
                    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                        $('#previewing').attr('src', 'noimage.png');
                        $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                        return false;
                    } else {
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });

            function imageIsLoaded(e) {
                $("#profile_picture_url").css("color", "green");
                $('#previewing').css("display", "block");
                $('#previewing').attr('src', e.target.result);
                $('#previewing').attr('width', '200px');
                $('#previewing').attr('height', '200px');
            }

            $('#update-profile').on('click',function(e){
                e.preventDefault();
                let formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('surname', $('#surname').val());
                formData.append('email', $('#email').val());
                formData.append('contact_number', $('#contact_number').val());
                formData.append('address', $('#address').val());
                jQuery.each(jQuery('#profile_picture_url')[0].files, function (i, file) {
                    formData.append('profile_picture_url', file);
                });
                console.log("user ", formData);
                let user = {!! $user !!};

                $.ajax({
                    url: "/profile-update/"+user.id,
                    processData: false,
                    contentType: false,
                    data: formData,
                    type: 'post',
                    success: function (response, a, b) {
                        console.log("success", response);
                        alert(response.message);
                        window.location.reload();
                    },
                    error: function (response) {
                        console.log("error", response);
                        let message = response.responseJSON.message;
                        console.log("error", message);
                        let errors = response.responseJSON.errors;

                        for (var error in   errors) {
                            console.log("error", error)
                            if (errors.hasOwnProperty(error)) {
                                message += errors[error] + "\n";
                            }
                        }
                        alert(message);
                    }
                });
            });
        });
    </script>
    @endpush
@endsection