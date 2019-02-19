@extends('layouts.admin-layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h6 style="text-align: center;margin-top:2em;font-weight: bolder;text-transform: uppercase;">Stock Assignment for Agent
                - {{$agent->name." ".$agent->surname}}</h6>
            <input id="agent_id" hidden value="{{$agent->id}}"/>

        </div>
        <div id="top-section" class="card hoverable" style="margin-left: 2em;margin-right: 2em;">
            <div class="row " >
                <div style="float: right; margin-top:1em;" >
                    <span id="products-selected-count">No products selected</span>
                    <button class="btn waves-effect waves-light modal-trigger" data-target="modal1"  disabled style="margin-right:2em;" id="assign-stock">Assign
                        Stock
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
            <div class="row" style="margin-left: 2em;margin-right: 2em;">
                <div class="col s12 ">
                    <table class="table table-bordered" style="width: 100%!important;" id="assign-stock-table">
                        <thead>
                        <tr>
                            <th>Select</th>
                            <th>Bar Code</th>
                            <th>Product Name</th>
                            <th>Product Category</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    {{--<div class="row">--}}
                    {{--<form class="col s12">--}}
                    {{--@csrf--}}
                    {{--<div class="input-field col m6">--}}
                    {{--<label>Select Products to Assign</label><br/><br/>--}}
                    {{--<select style="width: 100%;margin-top:1em;" id="product_id" multiple="multiple">--}}
                    {{--@foreach($products as $product)--}}
                    {{--<option value="{{$product->id}}" >{{$product->product_name}}</option>--}}
                    {{--@endforeach--}}
                    {{--</select>--}}
                    {{--<label for="receiver_id">Who Called</label>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                    {{--<div class="col offset-m4">--}}
                    {{--<a href="/assign-stock" class="waves-effect waves-green btn">Cancel<i class="material-icons right">close</i> </a>--}}
                    {{--<button class="btn waves-effect waves-light" style="margin-left:2em;" id="assign-products" name="action">Assign--}}
                    {{--<i class="material-icons right">send</i>--}}
                    {{--</button>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--</form>--}}
                    {{--</div>--}}

                </div>
            </div>
        </div>

    </div>

    <div id="modal1" class="modal">
        <div class="modal-header">
           <h6 style="font-weight: bolder;text-align: center;text-transform: uppercase;"> Assign Stock - Quantity Allocation</h6>
        </div>
        <div class="modal-content">
            <form id="quantities-table">
                <div class="row">
                    <table>
                        <thead>
                        <th>Bar Code</th><th>Product</th><th>Quantity</th>
                        </thead>
                        <tbody id="selected-products">

                        </tbody>
                    </table>
                </div>
                <div class="row" style="margin-top:2em;">
                    <div class="col offset-m4">
                        <a id="cancel-assign" class="waves-effect waves-green btn modal-close">Cancel<i class="material-icons right">close</i> </a>
                        <button class="btn waves-effect waves-light" style="margin-left:2em;" id="save-assigned_stock" name="action">Save
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>


    <style>
        th {
            text-transform: uppercase !important;
        }

        .check {
            opacity: 1 !important;
            pointer-events: auto !important;
        }

        table.dataTable tbody tr.selected {
            background-color: #B0BED9;
        }
    </style>
    @push('custom-scripts')

        <script>
            $(document).ready(function () {
                // $('select').formSelect();
                $('#product_id').select2();
                $(function () {

                    let url = '/get-unassigned-stock/' + $('#agent_id').val();
                    $('#assign-stock-table').DataTable({
                        processing: true,
                        serverSide: true,
                        paging: true,
                        responsive: true,
                        scrollX: 640,
                        ajax: {
                            'url': url,
                        },
                        columns: [
                            {data: 'action', name: 'action', orderable: false, searchable: false},
                            {data: 'barcode', name: 'barcode'},
                            {data: 'product_name', name: 'product_name'},
                            {data: 'product_category.category_name', name: 'product_category.category_name'},
                        ]
                    });
                    $('select[name="assign-stock-table_length"]').css("display", "inline");
                });

                $('#assign-stock-table tbody').on('click', 'tr', function () {
                    // alert("ndeip");
                    $(this).toggleClass('selected');
                    count_selected();
                });

                $('#assign-stock').on('click', function () {
                    $('#selected-products').empty();
                    let selected_products = $("table input:checkbox:checked").map(function () {
                        return $(this).val();
                    }).get();
                    let products = {!! $products !!};

                    for(var i=0;i<selected_products.length;i++){
                        let product = products.find(product => product.id == selected_products[i]);
                        console.log('Product',product);
                        $('#selected-products').append('<tr><td>'+product.barcode+'<td>'+product.product_name+' - '+ product.quantity+' Available</td><td> <input style="width:80px!important;" class="qty" min="0" max="'+product.quantity+'" required id="'+product.id+'" type="number" class="validate"/></td></tr>');
                    }

                });

                function count_selected() {
                    var count = $("table input[type=checkbox]:checked").length;
                    $('#products-selected-count').empty();
                    if (count <= 0) {
                        $('#assign-stock').prop("disabled", true);
                        $('#products-selected-count').append(' No Products Selected');
                    } else {
                        $('#assign-stock').prop("disabled", false);
                        $('#products-selected-count').append(count + ' Products Selected');
                    }
                }

                function getIDS() {
                    var searchIDs = $("table input:checkbox:checked").map(function () {
                        return $(this).val();
                    }).get();
                    console.log(searchIDs);
                }

                $('#quantities-table').on('submit', function (e) {
                    e.preventDefault();
                    let assigned_stock =[];
                    $('.qty').each(function(idx,item){
                       let product_id = item.id;
                       let quantity = item.value;
                       let stock = {
                           'product_id':product_id,
                           'quantity':quantity,
                           'user_id':$('#agent_id').val()
                       }
                       assigned_stock.push(stock);
                    });
                    console.log("Check assigned stock", assigned_stock);
                    let formData = new FormData();
                    formData.append('assigned_products',JSON.stringify(assigned_stock));

                    $.ajax({
                        url: "/save-assigned-stock",
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
