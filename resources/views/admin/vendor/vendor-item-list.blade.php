@extends('admin.layout', [
    'pageTitle' => 'All Vendor List',
    'currentPage' => 'vendor',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item">Vendor List</li>
    <li class="breadcrumb-item active">Item Lists</li>
@endsection

@section('custom-css')
    <style>
        .count {
            font-weight: bold !important;
        }

        .counter-card:hover {
            scale: 1.1 !important;
            cursor: pointer;
        }
    </style>
@endsection

@section('body')

    <div class="card">
        <div class="card-body row">
            <div class=" col-md-12 vendor__profile__details text-center">
                <img src="{{ asset('assets/img/section-images/johnbike.png') }}" alt="profile-img" height="70vh">
                <h4 class="fw-bold" style="color:#ff5f00;">{{ $data->store_name }}</h4>
                <h5 class="text-dark"><i class="fa fa-map-pin me-2" style="color:#ff5f00;"></i>{{ $data->region }},
                    {{ $data->city_town }}</h5>

                <div class=" text-center">
                    <a href="{{ url('admin/vendor?action=vendor-details&id=') . $id }}" type="button"
                        class="btn btn-sm btn-outline-primary">Vendor Details</a>
                    <button type="button" class="btn btn-sm btn-primary">Item Lists</button>
                    <a href="{{ url('admin/vendor?action=vendor-orders&id=') . $id }}" type="button"
                        class="btn btn-sm btn-outline-primary">Orders</a>
                    <a href="{{ url('admin/vendor?action=vendor-review-ratings&id=').$id }}" type="button" class="btn btn-sm btn-outline-primary">Review and Ratings</a>
                </div>

            </div>
            <div class="col-md-12 mt-3" style="border:1px solid #dee4e7;border-radius:10px">
                <div class="row">

                    <div class="col-12 text-center py-3">
                        <a href="{!! url('admin/vendor?action=vendor-item-lists&filter=Cycle&id=') . $id !!}"
                            class="btn btn-sm @if ($filter == 'Accessories') btn-outline-primary @else btn-primary @endif">Cycle</a>
                        <a href="{!! url('admin/vendor?action=vendor-item-lists&filter=Accessories&id=') . $id !!}"
                            class="btn btn-sm @if ($filter == 'Accessories') btn-primary @else btn-outline-primary @endif">Accessories</a>
                    </div>
                    <div class="col-12">
                        <div class="py-2">
                            <a href="{!! url('admin/vendor?action=vendor-add-item&item=Cycle&id=') . $id !!}" class="btn btn-info btn-sm"><i class="fas fa-plus"></i>&nbsp;
                                Add Cycle</a>
                            <a href="{!! url('admin/vendor?action=vendor-add-item&item=Accessories&id=') . $id !!}" class="btn btn-info btn-sm"><i class="fas fa-plus"></i>&nbsp;
                                Add Accessories</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <tr class="table-light">
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Stock</th>
                                <th>Categories</th>
                                <th>Is Active</th>
                            </tr>

                            @if (count($productData) > 0)
                                @foreach ($productData as $pData)
                                    <tr>
                                        <th>{{ 1 + $sn++ }}</th>
                                        <th><img src="{{ asset('assets/uploads/product-image') . '/' . $pData->product_thumbnail }}"
                                                width="70px" alt=""></th>
                                        <th>{{ $pData->product_name }}</th>
                                        <th>{!! $pData->product_description !!}</th>
                                        <th>{{ $pData->remaining_stock }}</th>
                                        <th>{{ $pData->categories }}</th>
                                        <th>
                                            @if ($pData->is_active == 1)
                                                <div class="form-check form-switch form-switch-success">
                                                    <input class="form-check-input DeactiveProduct"
                                                        data-id="{{ $pData->id }}" type="checkbox"
                                                        id="customSwitchSuccess" checked="">
                                                    <span class="badge badge-soft-success">Active</span>
                                                </div>
                                            @elseif($pData->is_active == 0)
                                                <div class="form-check form-switch form-switch-danger">
                                                    <input class="form-check-input activeProduct"
                                                        data-id="{{ $pData->id }}" type="checkbox"
                                                        id="customSwitchDanger" checked="">
                                                    <span class="badge badge-soft-danger">DeActive</span>
                                                </div>
                                            @endif
                                        </th>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">
                                        <h5 class="text-center">No Data Found</h5>
                                    </td>
                                </tr>
                            @endif


                        </table>
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
            // Active Product
            $(document).on('click', '.activeProduct', function(e) {
                var productId = $(this).data('id');

                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to Active this product ?');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('admin/vendor') }}",
                        type: "POST",
                        data: {
                            action: 'active-product',
                            _token: "{{ csrf_token() }}",
                            product_id: productId
                        },

                        beforeSend: function() {
                            $(this).attr('disabled', true).html("Please wait..");
                        },
                        success: function(data) {
                            if (!data.success) {
                                alert(data.message);
                                $(this).attr('disabled', false).html("Active");

                            } else {
                                alert(data.message);
                                window.location.reload();
                            }
                        }
                    });
                } else {
                    $(this).attr('disabled', false).html("Active");
                }


            });


            // DeActive Product
            $(document).on('click', '.DeactiveProduct', function(e) {
                var productId = $(this).data('id');

                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to DeActive this product ?');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('admin/vendor') }}",
                        type: "POST",
                        data: {
                            action: 'deactive-product',
                            _token: "{{ csrf_token() }}",
                            product_id: productId
                        },

                        beforeSend: function() {
                            $(this).attr('disabled', true).html("Please wait..");
                        },
                        success: function(data) {
                            if (!data.success) {
                                alert(data.message);
                                $(this).attr('disabled', false).html("DeActive");

                            } else {
                                alert(data.message);
                                window.location.reload();
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
