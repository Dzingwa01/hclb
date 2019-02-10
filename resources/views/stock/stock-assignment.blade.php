@extends('layouts.admin-layout')

@section('content')
    <div class="container">

        <div class="row" >
            <div class="col s12 card" style="margin-top:2em;" >
                <h5 style="text-align: center;">Stock Assignment for Agent - {{$agent->name." ".$agent->surname}}</h5>
                <div class="row">
                    <form class="col s12">
                        @csrf
                        <div class="input-field col m6">
                            <label>Select Products to Assign</label><br/><br/>
                            <select style="width: 100%;margin-top:1em;" id="product_id" multiple="multiple">
                                @foreach($products as $product)
                                    <option value="{{$product->id}}" >{{$product->product_name}}</option>
                                @endforeach
                            </select>
                            {{--<label for="receiver_id">Who Called</label>--}}
                        </div>
                        <div class="row">
                            <div class="col offset-m4">
                                <a href="/assign-stock" class="waves-effect waves-green btn">Cancel<i class="material-icons right">close</i> </a>
                                <button class="btn waves-effect waves-light" style="margin-left:2em;" id="assign-products" name="action">Assign
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
                // $('select').formSelect();
                $('#product_id').select2();

                $('#assign-products').on('click', function () {
                    alert("Coming Soon");
                    let formData = new FormData();
                    formData.append('barcode', $('#barcode').val());
                    formData.append('product_name', $('#product_name').val());
                    formData.append('price', $('#price').val());
                    formData.append('description', $('#description').val());

                    // $.ajax({
                    //     url: "/product-update/",
                    //     processData: false,
                    //     contentType: false,
                    //     data: formData,
                    //     type: 'post',
                    //
                    //     success: function (response, a, b) {
                    //         console.log("success", response);
                    //
                    //         window.location.href = '/products';
                    //     },
                    //     error: function (response) {
                    //         console.log("error", response);
                    //         let message = response.responseJSON.message;
                    //         console.log("error", message);
                    //         let errors = response.responseJSON.errors;
                    //
                    //         for (var error in   errors) {
                    //             console.log("error", error)
                    //             if (errors.hasOwnProperty(error)) {
                    //                 message += errors[error] + "\n";
                    //             }
                    //         }
                    //         alert(message);
                    //         $("#modal1").close();
                    //     }
                    // });
                });
            });

        </script>
    @endpush
@endsection
