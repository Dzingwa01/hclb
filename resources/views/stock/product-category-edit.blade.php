@extends('layouts.admin-layout')

@section('content')
    <div class="container">

        <div class="row" >
            <div class="col s12 card" style="margin-top:2em;">
                <h5 style="text-align: center">Edit Product Category</h5>
                <div class="row">
                    <form class="col s12">
                        @csrf
                        <div class="row">
                            <div class="input-field col m6">
                                <input id="category_name" type="text" value="{{$productCategory->category_name}}" class="validate">
                                <label for="location_name">Product category Name</label>
                            </div>
                            <div class="input-field col m6">
                                <textarea id="description" class="materialize-textarea">{{$productCategory->description}}</textarea>
                                <label for="description">Category Description</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col offset-m4">
                                <a href="/product-categories" class="waves-effect waves-green btn">Cancel<i class="material-icons right">close</i> </a>
                                <button class="btn waves-effect waves-light" style="margin-left:2em;" id="update-product-category" name="action">Submit
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

                $('#update-product-category').on('click', function () {
                    let formData = new FormData();
                    formData.append('category_name', $('#category_name').val());
                    formData.append('description', $('#description').val());
                    let category = {!! $productCategory !!}
                    $.ajax({
                        url: "/product-category-update/"+category.id,
                        processData: false,
                        contentType: false,
                        data: formData,
                        type: 'post',

                        success: function (response, a, b) {
                            console.log("success", response);
                            alert(response.message);
                            window.location.href = '/product-categories';
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
