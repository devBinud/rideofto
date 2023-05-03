@extends('vendor.layout', [
    'pageTitle' => 'Discount',
    'currentPage' => 'discount',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Discount</li>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('body')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fas fa-percent"></i> Add Discount</h4>
        </div>
        <!--end card-header-->
        <form action="{{ url('vendor/discount?action=add-discount') }}" id="addDiscountForm" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-material">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="my-3 required">Discount Type</label>
                            <div>
                                <select class="form-select" name="discount_type" aria-label="Default select example">
                                    <option value="">Select Discount Type</option>
                                    <option value="1">Flat</option>
                                    <option value="2">Percentage</option>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-md-4">
                            <label class="my-3 required">Select Category Or Product</label>
                            <div>
                                <select class="form-select" id="selectDiscountFor" name="selectDiscountFor"
                                    aria-label="Default select example">
                                    <option value="">Please Select category Or product</option>
                                    <option value="1">Category</option>
                                    <option value="2">Product</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="my-3 required">Select option</label>
                            <div>
                                <select class="select2 mb-3 select2-multiple" id="product_or_category"
                                    name="product_or_categoryIds[]" style="width: 100%" multiple="multiple"
                                    data-placeholder="Choose">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="my-3 required">Discount Amount</label>
                            <input type="text" class="form-control" placeholder="Enter discount amount"
                                name="discount_amount">
                        </div>
                        <!--end col-->
                        <div class="col-md-4">
                            <label class="my-3 required">Start Date</label>
                            <input type="datetime-local" class="form-control" name="start_date">
                        </div>
                        <div class="col-md-4">
                            <label class="my-3 required">End Date</label>
                            <input type="datetime-local" class="form-control" name="end_date">
                        </div>
                        <!--end col-->
                    </div>
                    <button class="btn btn-primary mt-3 mb-3 float-end" id="btnSubmit"><i class="fas fa-paper-plane"></i>
                        Save</button>
                    <!--end row-->
                </div>
            </div>
        </form>
        <!--end card-body-->
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fas fa-percent"></i> Discount List</h4>
        </div>
        <div class="card-body">
            @if (count($discountList) > 0)
                <div class="table table-responsive ">
                    <table class="table table-bordered text-center">
                        <thead class="bg-dark text-uppercase ">
                            <th class="text-white">#</th>
                            <th class="text-white">Discount Type</th>
                            <th class="text-white">Product Or Category</th>
                            <th class="text-white">Discount Amount</th>
                            <th class="text-white">Start Date</th>
                            <th class="text-white">End Date</th>
                            <th class="text-white">Is Active</th>
                            <th class="text-white">Action</th>

                        </thead>
                        <tbody>
                            @foreach ($discountList as $data)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $data->discount_type }}</td>
                                    <td>{{$data->discount_product_or_category}}</td>
                                    <td>{{ $data->discount }}</td>
                                    <td>{{ date('d M,Y h:i A', strtotime($data->starting_from)) }}</td>
                                    <td>{{ date('d M,Y h:i A', strtotime($data->valid_till)) }}</td>
                                    <td>
                                        @if ($data->is_active == 1)
                                            <div class="form-check form-switch form-switch-success">
                                                <input class="form-check-input deactiveDiscount"
                                                    data-id="{{ $data->id }}" type="checkbox" id="customSwitchSuccess"
                                                    checked="">
                                                <span class="badge badge-soft-success">Active</span>
                                            </div>
                                        @elseif($data->is_active == 0)
                                            <div class="form-check form-switch form-switch-danger">
                                                <input class="form-check-input activeDiscount" data-id="{{ $data->id }}"
                                                    type="checkbox" id="customSwitchDanger" checked="">
                                                <span class="badge badge-soft-danger">DeActive</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-primary btn-sm viewDiscountBtn"
                                            discount-id="{{ $data->id }}" data-bs-toggle="modal"
                                            data-bs-target="#viewDiscountModal" title="View Discount">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="{{ url('vendor/discount?action=edit-discount&id=' . $data->id) }}"
                                            class="btn btn-secondary btn-sm unitData px-2" title="Edit Discount">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a title="Delete Discount" type="button" class="btn btn-danger btn-sm deleteDiscount"
                                            data-id="{{ $data->id }}">
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
                <h4 class="text-center text-danger mt-4 p-4">Discount Not Avliable!</h4>
            @endif
        </div>
    </div>


    <!-- Start View Discount Partials -->
    <div class="modal fade bd-example-modal-lg" id="viewDiscountModal" tabindex="-1"
        aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel"><i class="fas fa-percent"></i> View Discount
                        Details</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="viewDiscountPartialsBtn"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- End View Discount Partials -->


@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // Select Option
            $('.select2').select2({

            });

            // when discount type selected
            $('#selectDiscountFor').change(function() {
                var discountFor = $(this).val();
                $('#product_or_category').html('Please select...');

                $.ajax({
                    url: "{{ url('vendor/discount/for?for=') }}" + discountFor,
                    type: "GET",
                    success: function(data) {
                        if (!data.success) {
                            alert(data.message);
                            return;
                        }

                        if (data != null) {
                            var discount = data.data;
                            console.log(discount);
                            $.each(discount, function(key, value) {
                                var discountVal = "";
                                switch (discountFor) {
                                    case '1':
                                        $('#product_or_category').append(
                                            '<option value="' +
                                            value
                                            .category_id +
                                            '">' +
                                            value.product_category + '</option>');
                                        break;
                                    case '2':
                                        $('#product_or_category').append(
                                            '<option value="' +
                                            value
                                            .id +
                                            '">' +
                                            value.product_name + '</option>');
                                        break;
                                }

                            });
                        }
                    },
                });
            });

            // ADD Discount
            $('#addDiscountForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#btnSubmit");

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        submit.attr('disabled', true).html('Please wait..');
                    },
                    success: function(data) {
                        if (!data.success) {
                            swal('Oops...', data.message, 'error');
                        } else {
                            swal('Success!', data.message, {
                                    icon: "success",
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Save');
                    }
                });
            });

            //  Pagination 
            $("#paginationBox").pxpaginate({
                currentpage: {{ $discountList->currentPage() }},
                totalPageCount: {{ ceil($discountList->total() / $discountList->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('vendor/discount?add-discount&page=') !!}" + pagenumber;
                    window.location.replace(url);
                },
            });


            // Discount Partials For View 
            $(document).on("click", ".viewDiscountBtn", function() {
                let discountId = $(this).attr('discount-id');
                $('#viewDiscountPartialsBtn').html('<h5 class="text-center">Please wait...</h5>')

                var url = "{{ url('vendor/discount?action=view-discount') }}";

                $.get(url + "&discountId=" + discountId,
                    function(data) {
                        $('#viewDiscountPartialsBtn').html(data.html);
                    });
            });

            // Delete Product 
            $('.deleteDiscount').click(function() {
                let discountId = $(this).attr('data-id');

                swal({
                        title: "Are you sure?",
                        text: "Do you want to delete this Discount !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "{{ url('vendor/discount?action=delete-discount') }}",
                                type: 'post',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    discountId: discountId,
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

            // Active Discount
            $(document).on('click', '.activeDiscount', function(e) {
                var discountId = $(this).data('id');

                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to activate this Discount ?');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('vendor/discount') }}",
                        type: "POST",
                        data: {
                            action: 'active-discount',
                            _token: "{{ csrf_token() }}",
                            discount_id: discountId,
                            isActive: '1'
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


            // DeActive Discount
            $(document).on('click', '.deactiveDiscount', function(e) {
                var discountId = $(this).data('id');
                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to deactivate this Discount ?');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('vendor/discount') }}",
                        type: "POST",
                        data: {
                            action: 'active-discount',
                            _token: "{{ csrf_token() }}",
                            discount_id: discountId,
                            isActive: '0'
                        },

                        beforeSend: function() {
                            $(this).attr('disabled', true).html("Please wait..");
                        },
                        success: function(data) {
                            if (!data.success) {
                                swal('Oops...', data.message, 'error');
                                $(this).attr('disabled', false).html("DeActive");

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
                    $(this).attr('disabled', false).html("DeActive");
                }


            });

        });
    </script>
@endsection
