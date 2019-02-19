@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div  style="margin-top:3em;">
            <div class="row">
                <h6 style="text-align: center;font-weight: bolder;margin-top:2em;text-transform: uppercase">Add New Agent</h6>
                <form class="card hoverable" style="margin: 1em;" id="save-agent-form">
                    @csrf
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <input required id="name" type="text" class="validate">
                            <label for="name">Agent Name</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <input required id="surname" type="text" class="validate">
                            <label for="surname">Agent Surname</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <input required id="email" type="email" class="validate">
                            <label for="email">Agent Email</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <input required id="contact_number" type="tel" class="validate">
                            <label for="contact_number">Agent Contact Number</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <textarea required id="address" class="materialize-textarea"></textarea>
                            <label for="address">Agent Address</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <select required id="location_id">
                                @foreach($locations as $location)
                                    <option value="{{$location->id}}">{{$location->location_name}}</option>
                                @endforeach
                            </select>
                            <label>Agent Location</label>
                        </div>
                    </div>

                    <div class="row" >
                        <div class="col offset-m4" style="margin-bottom:2em;">
                        <a href="{{url('users')}}" class=" waves-effect waves-green btn">Cancel<i
                                    class="material-icons right">close</i> </a>
                        <button class="btn waves-effect waves-light" style="margin-left:2em;" id="save-agent"
                                name="action">Submit
                            <i class="material-icons right">send</i>
                        </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @push('custom-scripts')

        <script>
            $(document).ready(function () {
                $('select').formSelect();

            });

            $('#save-agent-form').on('submit',function(e){
                e.preventDefault();
                let formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('surname', $('#surname').val());
                formData.append('email', $('#email').val());
                formData.append('contact_number', $('#contact_number').val());
                formData.append('address', $('#address').val());
                formData.append('location_id', $('#location_id').val());
                console.log("user ", formData);

                $.ajax({
                    url: "{{ route('users.store') }}",
                    processData: false,
                    contentType: false,
                    data: formData,
                    type: 'post',
                    success: function (response, a, b) {
                        console.log("success", response);
                        alert(response.message);
                        window.location.href = '/users';
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
        </script>
    @endpush
@endsection
