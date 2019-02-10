@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h6 style="text-transform:uppercase;text-align: center;font-weight: bolder;margin-top:2em;">Agents</h6>
            {{--<a class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>--}}
        </div>
        <div class="row" style="margin-left: 2em;margin-right: 2em;">
            <div class="col s12">
                <h4>Edit Agent Location</h4>
                <div class="row">
                    <form class="col s12">
                        @csrf
                        <div class="row">
                            <div class="input-field col m6">
                                <input id="location_name" type="text" value="{{$location->location_name}}" class="validate">
                                <label for="location_name">Location Name</label>
                            </div>
                            <div class="input-field col m6">
                                <input id="city" type="text" value="{{$location->city}}" class="validate">
                                <label for="city">City</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m6">
                                <textarea id="description" class="materialize-textarea">{{$location->description}}</textarea>
                                <label for="description">Description</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col offset-m4">
                                <a href="{{url('locations')}}" class="waves-effect waves-green btn">Cancel<i class="material-icons right">arrow_back</i> </a>
                                <button class="btn waves-effect waves-light" style="margin-left:2em;" id="update-location" name="action">Update
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>


        <style>
            th{
                text-transform: uppercase!important;
            }
        </style>
    </div>
    @push('custom-scripts')

        <script>
            $(document).ready(function () {
                $('select').formSelect();

                $('#update-location').on('click', function () {
                    let formData = new FormData();
                    formData.append('location_name', $('#location_name').val());
                    formData.append('city', $('#city').val());
                    formData.append('description', $('#description').val());
                    let location = {!! $location !!};
                    $.ajax({
                        url: "/location-update/"+location.id,
                        processData: false,
                        contentType: false,
                        data: formData,
                        type: 'post',

                        success: function (response, a, b) {
                            console.log("success", response);
                            alert(response.message);
                            window.location.href = '/locations';
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
                            $("#modal1").close();
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection
