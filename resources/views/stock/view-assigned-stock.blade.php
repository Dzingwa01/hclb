@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h6 style="text-transform:uppercase;text-align: center;font-weight: bolder;margin-top:2em;">Assigned Stock for {{$agent->name.' '.$agent->surname}}</h6>
            <input id="user_id" value="{{$agent->id}}" hidden/>
        </div>
        <div class="row" style="margin-left: 2em;margin-right: 2em;">
            <div class="col s12 card hoverable">
                <table class="table table-bordered" style="width: 100%!important;" id="stock-table">
                    <thead>
                    <tr>
                        <th>Bar Code</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Value(R)</th>
                        <th>Description</th>
                        <th>Product Category</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large teal tooltipped btn" data-position="left" data-tooltip="Add New Product" href="{{url('create-product')}}">
                <i class="large material-icons">add</i>
            </a>
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
                let url = '/get-agent-assigned-products/'+$('#user_id').val();
                $(function () {
                    $('#stock-table').DataTable({
                        processing: true,
                        serverSide: true,
                        paging: true,
                        responsive: true,
                        scrollX: 640,
                        ajax: {
                            'url':url
                        },
                        columns: [
                            {data: 'barcode', name: 'barcode'},
                            {data: 'product_name', name: 'product_name'},
                            {data: 'pivot.product_quantity', name: 'pivot.product_quantity'},
                            {data: 'total_value', name: 'total_value'},
                            {data: 'description', name: 'description'},
                            {data: 'product_category.category_name', name: 'product_category.category_name'},
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
                    formData.append('category_id', $('#category_id').val());

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
