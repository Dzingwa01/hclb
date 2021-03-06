@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">

        <div class="row" style="margin-left: 1em;margin-right: 1em;">
            <h6 style="text-transform:uppercase;text-align: center;font-weight: bolder;margin-top:2em;">Agents</h6>
            <div class="col s12 card hoverable">
                <table class="table table-bordered" style="width: 100%!important;margin-bottom: 2em;" id="users-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>System Role</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large teal tooltipped btn modal-trigger" data-position="left" data-tooltip="Add New Agent" href="{{url('create-user')}}">
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
                $(function () {
                    $('#users-table').DataTable({
                        processing: true,
                        serverSide: true,
                        paging: true,
                        responsive: true,
                        scrollX: 640,
                        ajax: '{{route('get-users')}}',
                        columns: [
                            {data: 'name', name: 'name'},
                            {data: 'surname', name: 'surname'},
                            {data: 'email', name: 'email'},
                            {data: 'contact_number', name: 'contact_number'},
                            {data: 'location.location_name', name: 'location.location_name'},
                            {data:'roles[0].name',name:'roles[0].name'},
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                        ]
                    });
                    $('select[name="users-table_length"]').css("display","inline");
                });

            });

        </script>
    @endpush
@endsection
