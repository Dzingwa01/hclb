@extends('layouts.admin-layout')

@section('content')
    <div class="container">

        <div class="row" >
            <div class="col s12 card" style="margin-top:2em;">
                <h5 style="text-align: center;">Add New Product</h5>
                <div class="row">
                    <form id="save-product-form" enctype="multipart/form-data" class="col s12">
                        @csrf
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <input id="barcode" required type="text" class="validate">
                                <label for="barcode">Product BarCode</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <input required id="product_name" type="text" class="validate">
                                <label for="product_name">Product Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <input required id="price" type="text" class="validate">
                                <label for="price">Product Prize</label>
                            </div>
                            <div class="input-field col m6">
                                <textarea  id="description" class="materialize-textarea"></textarea>
                                <label for="description">Product Description</label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="input-field col m6">
                                <select required id="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                <label>Product Category</label>
                            </div>
                            <div class="col m6">
                                <img src="" id="previewing">
                                <div class="file-field input-field" style="bottom:0px!important;">
                                    <div class="btn">
                                        <span>Upload Product Image</span>
                                        <input id="product_image_url" type="file">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                    <span id="message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col offset-m4">
                                <a href="{{url('products')}}" class="waves-effect waves-green btn">Cancel<i class="material-icons right">close</i> </a>
                                <button class="btn waves-effect waves-light" style="margin-left:2em;" id="save-product" name="action">Submit
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
                $(function () {
                    $("#product_image_url").change(function () {
                        $("#message").empty(); // To remove the previous error message
                        var file = this.files[0];
                        var imagefile = file.type;
                        var match = ["image/jpeg", "image/png", "image/jpg"];
                        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                            $('#previewing').attr('src', 'noimage.png');
                            $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                            return false;
                        }
                        else {
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
                $('#save-product-form').on('submit', function (e) {
                    e.preventDefault();
                    let formData = new FormData();
                    formData.append('barcode', $('#barcode').val());
                    formData.append('product_name', $('#product_name').val());
                    formData.append('price', $('#price').val());
                    formData.append('description', $('#description').val());
                    formData.append('category_id', $('#category_id').val());
                    jQuery.each(jQuery('#product_image_url')[0].files, function (i, file) {
                        formData.append('product_image_url', file);
                    });

                    $.ajax({
                        url: "{{ route('products.store') }}",
                        processData: false,
                        contentType: false,
                        data: formData,
                        type: 'post',

                        success: function (response, a, b) {
                            console.log("success", response);
                            alert(response.message);
                            window.location.href = "/products";
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
                            // $("#modal1").close();
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection
