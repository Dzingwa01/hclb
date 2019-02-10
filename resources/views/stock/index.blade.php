@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h6 style="text-transform:uppercase;text-align: center;font-weight: bolder;margin-top:2em;">Stock List</h6>
            {{--<a class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>--}}
        </div>
        <div class="row" style="margin-left: 2em;margin-right: 2em;">
            <div class="col s12">
                <table class="table table-bordered" style="width: 100%!important;" id="stock-table">
                    <thead>
                    <tr>
                        <th>Bar Code</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large teal tooltipped btn modal-trigger" data-position="left" data-tooltip="Add New Product" href="#modal1">
                <i class="large material-icons">add</i>
            </a>
        </div>
        <div id="modal1" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4>Add New Product</h4>
                <div class="row">
                    <form class="col s12">
                        @csrf
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <input id="barcode" type="text" class="validate">
                                <label for="barcode">Product BarCode</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <input id="product_name" type="text" class="validate">
                                <label for="product_name">Product Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <input id="price" type="text" class="validate">
                                <label for="price">Product Prize</label>
                            </div>
                            <div class="input-field col m6">
                                <textarea id="description" class="materialize-textarea"></textarea>
                                <label for="description">Product Description</label>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn">Cancel<i class="material-icons right">close</i> </a>
                <button class="btn waves-effect waves-light" style="margin-left:2em;" id="save-product" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
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
                    $('#stock-table').DataTable({
                        processing: true,
                        serverSide: true,
                        paging: true,
                        responsive: true,
                        scrollX: 640,
                        ajax: '{{route('get-products')}}',
                        columns: [
                            {data: 'barcode', name: 'barcode'},
                            {data: 'product_name', name: 'product_name'},
                            {data: 'price', name: 'price'},
                            {data: 'description', name: 'description'},
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                        ]
                    });
                    $('select[name="stock-table_length"]').css("display","inline");
                });
                $('#save-product').on('click', function () {
                    let formData = new FormData();
                    formData.append('barcode', $('#barcode').val());
                    formData.append('product_name', $('#product_name').val());
                    formData.append('price', $('#price').val());
                    formData.append('description', $('#description').val());

                    $.ajax({
                        url: "{{ route('products.store') }}",
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
                            $("#modal1").close();
                        }
                    });
                });
            });

        </script>
    @endpush
@endsection
