@extends('layouts.admin-layout')

@section('content')
    <div class="container">

        <div class="row" >
            <div class="col s12 card" style="margin-top:2em;" >
                <h5 style="text-align: center;">Edit Product</h5>
                <div class="row">
                    <form class="col s12">
                        @csrf
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <input id="barcode" value="{{$product->barcode}}" type="text" class="validate">
                                <label for="barcode">Product BarCode</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <input id="product_name" value="{{$product->product_name}}" type="text" class="validate">
                                <label for="product_name">Product Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <input id="price" value="{{$product->price}}" type="text" class="validate">
                                <label for="price">Product Prize</label>
                            </div>
                            <div class="input-field col m6">
                                <textarea id="description" class="materialize-textarea">{{$product->description}}</textarea>
                                <label for="description">Product Description</label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="input-field col m6">
                                <select id="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{$product->category_id==$category->id?'selected':''}}>{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                <label>Product Category</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col offset-m4">
                                <a href="/products" class="waves-effect waves-green btn">Cancel<i class="material-icons right">close</i> </a>
                                <button class="btn waves-effect waves-light" style="margin-left:2em;" id="update-product" name="action">Update
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

                $('#update-product').on('click', function () {
                    let formData = new FormData();
                    formData.append('barcode', $('#barcode').val());
                    formData.append('product_name', $('#product_name').val());
                    formData.append('price', $('#price').val());
                    formData.append('description', $('#description').val());
                    formData.append('category_id', $('#category_id').val());

                    let product = {!! $product !!}
                    $.ajax({
                        url: "/product-update/"+product.id,
                        processData: false,
                        contentType: false,
                        data: formData,
                        type: 'post',

                        success: function (response, a, b) {
                            console.log("success", response);
                            alert(response.message);
                            window.location.href = '/products';
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
