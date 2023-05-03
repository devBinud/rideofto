@extends('vendor.layout', [
    'pageTitle' => 'All Products',
    'currentPage' => 'allProducts',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">All Products</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    <div class="card">
        <div class="card-body">
            @if (count($allProducts) > 0)
                <div class="table table-responsive ">
                    <table class="table table-bordered text-center">
                        <thead class="bg-dark text-uppercase ">
                            <th class="text-white">#</th>
                            <th class="text-white">Product Type</th>
                            <th class="text-white">Product Name</th>
                            <th class="text-white">Description</th>
                            <th class="text-white">Initial Stock</th>
                            <th class="text-white">Remaining Stock</th>
                            <th class="text-white">Is Active</th>
                            <th class="text-white" style="width: 10% !important">Action</th>

                        </thead>
                        <tbody>
                            @foreach ($allProducts as $item)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $item->product_type }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{!! $item->product_description !!}</td>
                                    <td>{{ $item->initial_stock }}</td>
                                    <td>{{ $item->remaining_stock }}</td>
                                    <td>
                                        @if ($item->is_active == 1)
                                            <div class="form-check form-switch form-switch-success">
                                                <input class="form-check-input deactiveProduct"
                                                    data-id="{{ $item->id }}" type="checkbox" id="customSwitchSuccess"
                                                    checked="">
                                                <span class="badge badge-soft-success">Active</span>
                                            </div>
                                        @elseif($item->is_active == 0)
                                            <div class="form-check form-switch form-switch-danger">
                                                <input class="form-check-input activeProduct" data-id="{{ $item->id }}"
                                                    type="checkbox" id="customSwitchDanger" checked="">
                                                <span class="badge badge-soft-danger">DeActive</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-primary btn-sm viewDetails"
                                            data-id="{{ $item->id }}" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalPrimary1">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ url('vendor/product?action=edit-product&id=' . $item->id) }}"
                                            class="btn btn-secondary btn-sm unitData" title="Edit Product">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete Product" type="button" class="btn btn-danger btn-sm deleteProduct"
                                            data-id="{{ $item->id }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="paginationBox" class="my-5"></div>
            @else
                <h4 class="text-center text-danger mt-4 p-4">No Product Found!</h4>
            @endif
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">View Product Details</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body details">
                    <div id="details" style="min-height:250px!important;">

                    </div>
                    <div class="float-end">
                        <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#paginationBox").pxpaginate({
                currentpage: {{ $allProducts->currentPage() }},
                totalPageCount: {{ ceil($allProducts->total() / $allProducts->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('vendor/product?action=all-product&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });

            $(document).on("click", ".viewDetails", function() {
                let productId = $(this).attr('data-id');
                $('#details').html('<h5 class="text-center">Please wait...</h5>')

                var url = "{{ url('vendor/product?action=view-product-partials') }}";

                $.get(url + "&productId=" + productId,
                    function(data) {
                        $('#details').html(data.html);
                    });
            });

            // Delete Product 
            $('.deleteProduct').click(function() {
                let productId = $(this).attr('data-id');

                swal({
                        title: "Are you sure?",
                        text: "Do you want to delete this data !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "{{ url('vendor/product?action=delete-product') }}",
                                type: 'post',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    productId: productId,
                                },
                                success: function(data) {
                                    if (!data.success) {
                                        if (data.data != null) {
                                            $.each(data.data, function(id, error) {
                                                $('#' + id).text(error);
                                            });
                                        } else {
                                            swal('Oops...', data.message, 'error');
                                            // setTimeout(() => {
                                            //     window.location.reload();
                                            // }, 5000);
                                        }
                                    } else {
                                        swal('Success!', data.message, {
                                            icon: "success",
                                        });
                                        // swal('Success', data.message, 'success');
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2000);
                                    }
                                }
                            });
                        }
                    })
            });


            // Active Product
            $(document).on('click', '.activeProduct', function(e) {
                var productId = $(this).data('id');

                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to active this product ?');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('vendor/product') }}",
                        type: "POST",
                        data: {
                            action: 'active-product',
                            _token: "{{ csrf_token() }}",
                            product_id: productId,
                            status: '1',
                        },

                        beforeSend: function() {
                            $(this).attr('disabled', true).html("Please wait..");
                        },
                        success: function(data) {
                            if (!data.success) {
                                swal('Oops...', data.message, 'error');
                                $(this).attr('disabled', false).html("Active");

                            } else {
                                swal('Success!', data.message, {
                                    icon: "success",
                                });
                                // swal('Success', data.message, 'success');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            }
                        }
                    });
                } else {
                    $(this).attr('disabled', false).html("Active");
                }


            });


            // DeActive Product
            $(document).on('click', '.deactiveProduct', function(e) {
                var productId = $(this).data('id');
                // alert(productId);

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to deactivate this product ?');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('vendor/product') }}",
                        type: "POST",
                        data: {
                            action: 'active-product',
                            _token: "{{ csrf_token() }}",
                            product_id: productId,
                            status: '0',
                        },

                        beforeSend: function() {
                            $(this).attr('disabled', true).html("Please wait..");
                        },
                        success: function(data) {
                            if (!data.success) {
                                swal('Oops...', data.message, 'error');
                                $(this).attr('disabled', false).html("Active");

                            } else {
                                swal('Success!', data.message, {
                                    icon: "success",
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            }
                        }
                    });
                } else {
                    $(this).attr('disabled', false).html("DeActive");
                }


            });
        });
    </script>
@endsection
