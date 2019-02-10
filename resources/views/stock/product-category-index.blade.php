@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h6 style="text-transform:uppercase;text-align: center;font-weight: bolder;margin-top:2em;">Agents</h6>
            {{--<a class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>--}}
        </div>
        <div class="row" style="margin-left: 2em;margin-right: 2em;">
            <div class="col s12">
                <table class="table table-bordered" style="width: 100%!important;" id="categories-table">
                    <thead>
                    <tr>
                        <th>Category name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large teal tooltipped btn modal-trigger" data-position="left" data-tooltip="Add New Category" href="#modal1">
                <i class="large material-icons">add</i>
            </a>

        </div>
        <div id="modal1" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4>Add Product Category</h4>
                <div class="row">
                    <form class="col s12">
                        @csrf
                        <div class="row">
                            <div class="input-field col m6">
                                <input id="category_name" type="text" class="validate">
                                <label for="location_name">Product category Name</label>
                            </div>
                            <div class="input-field col m6">
                                <textarea id="description" class="materialize-textarea"></textarea>
                                <label for="description">Category Description</label>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn">Cancel<i class="material-icons right">close</i> </a>
                <button class="btn waves-effect waves-light" style="margin-left:2em;" id="save-product-category" name="action">Submit
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
                    $('#categories-table').DataTable({
                        processing: true,
                        serverSide: true,
                        paging: true,
                        responsive: true,
                        scrollX: 640,
                        ajax: '{{route('get-product-categories')}}',
                        columns: [
                            {data: 'category_name', name: 'category_name'},
                            {data: 'description', name: 'description'},
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                        ]
                    });
                    $('select[name="categories-table_length"]').css("display","inline");
                });
                $('#save-product-category').on('click', function () {
                    let formData = new FormData();
                    formData.append('category_name', $('#category_name').val());
                    formData.append('description', $('#description').val());

                    $.ajax({
                        url: "{{ route('product-categories.store') }}",
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
