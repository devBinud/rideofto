@extends('admin.layout', [
    'pageTitle' => 'All Vendor List',
    'currentPage' => 'vendor',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Vendor List</li>
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
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary">Add
                Vendor</button>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if (count($vendorData) > 0)
                <div class="table table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="bg-secondary">
                            <th>#</th>
                            <th class="text-start">Store Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>City / Town</th>
                            <th>Postal Code</th>
                            <th>Address</th>
                            <th>Change Password</th>
                            <th>Is Active</th>
                            <th>Action</th>

                        </thead>
                        <tbody>
                            @foreach ($vendorData as $data)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td class="text-start"><a class="text-primary"
                                            href="{{ url('admin/vendor?action=vendor-details&id=') . $data->id }}"
                                            target="_blank">{{ $data->store_name }}</a></td>
                                    <td>{{ $data->store_phone }}</td>
                                    <td>
                                        @if ($data->store_email == null)
                                            N/A
                                        @else
                                            {{ $data->store_email }}
                                        @endif
                                    </td>
                                    <td>{{ $data->city_town }}</td>
                                    <td>{{ $data->postal_code }}</td>
                                    <td>{{ $data->address }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm resetPasswordBtn"
                                            data-bs-toggle="modal" data-bs-target="#passwordReset"
                                            data-id="{{ $data->id }}"><i class="fas fa-lock"></i> Change
                                        </button>
                                    </td>
                                    <td>
                                        @if ($data->is_active == 1)
                                            <div class="form-check form-switch form-switch-success">
                                                <input class="form-check-input deactiveVendor" data-id="{{ $data->id }}"
                                                    type="checkbox" id="customSwitchSuccess" checked="">
                                                <span class="badge badge-soft-success">Active</span>
                                            </div>
                                            {{-- <button class="btn btn-success  btn-sm DeactiveUser"
                                                data-id="{{ $data->id }}">Active</button> --}}
                                        @elseif($data->is_active == 0)
                                            <div class="form-check form-switch form-switch-danger">
                                                <input class="form-check-input activeVendor" data-id="{{ $data->id }}"
                                                    type="checkbox" id="customSwitchDanger" checked="">
                                                <span class="badge badge-soft-danger">DeActive</span>
                                            </div>
                                            {{-- <button class="btn btn-warning  btn-sm activeUser"
                                                data-id="{{ $data->id }}">Deactive</button> --}}
                                        @endif
                                    </td>
                                    <td><a type="button" class="tippy-btn viewDetails px-2" data-id="{{ $data->id }}"
                                            data-bs-toggle="modal" data-bs-target="#exampleModalPrimary1">
                                            <i class="" data-feather="eye"></i>
                                        </a>
                                        <a href="{{ url('admin/vendor?action=edit-vendor&vendorId=') . $data->id }}">
                                            <i data-feather="edit"></i></a>

                                        <a type="button" data-id="{{ $data->id }}" class="del"><i
                                                data-feather="trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="paginationBox" class="my-5"></div>
            @else
                <h4 class="text-center text-danger mt-4 p-4">No vendor data found!</h4>
            @endif
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Add Vendor</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/vendor?action=add-vendor') }}" method="POST" id="addVendor"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="form-label required">Store Name</label>
                                        <input type="text" name="sName" class="form-control"
                                            placeholder="Enter store name">
                                    </div>


                                    <div class="col-md-6 ">
                                        <label for="" class="form-label required">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" maxlength="10"
                                            placeholder="Enter phone number">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="" class="form-label required">City / Town</label>
                                        <select name="cityId" id="" class="form-select">
                                            <option value="">Please select</option>
                                            @foreach ($city as $item)
                                                <option value="{{ $item->id }}">{{ $item->city_town }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label for="" class="form-label required">Postal Code</label>
                                        <input type="text" name="postalcode" class="form-control" maxlength="6"
                                            placeholder="Enter postal code">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="" class="form-label required">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            placeholder="Enter Address">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="" class="form-label required">Latitude</label>
                                        <input type="text" name="latitude" class="form-control"
                                            placeholder="Enter latitude">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="" class="form-label required">Longitude</label>
                                        <input type="text" name="logitude" class="form-control"
                                            placeholder="Enter longitude">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="" class="form-label required">Delivery Availability</label>
                                        <select name="delivery" id="" class="form-select avl">
                                            <option value="">Please select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-2 d-none dist">
                                        <label for="" class="form-label">Max Delivery Distance</label>
                                        <input type="text" name="distance" class="form-control"
                                            placeholder="Enter msx delivery distance (in meters)">
                                    </div>


                                </div>

                            </div>
                            <div class="col-md-4 mt-4">
                                <div class="card p-2" style="border-radius: 10%">
                                    <div class="card-header text-center">

                                        <h5 class="text-dark required">Image</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-2" id="imgHolder" style="min-height: 120px;">

                                            <img src="{{ asset('./assets/images/head_amethyst.png') }}"
                                                style="width: 40%;border-radius:10%" alt="">
                                        </div>


                                        <div class="col-md-12 pl-md-1 mt-2 mt-lg-0">
                                            <button class="btn btn-warning" id="btnUploadImg" type="button">
                                                Upload image</button>

                                        </div>

                                        <span class="error text-danger text-center" id="imgErr"></span>
                                    </div>
                                    <input type="file" accept='image/jpeg,image/gif,image/png' class="d-none"
                                        name="img_file" id="imgFile">
                                    <input type="hidden" name="img_text" id="imgText">
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="" class="form-label required">Owner Name</label>
                                <input type="text" name="ownerName" class="form-control"
                                    placeholder="Enter owner name" required>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="" class="form-label required">Owner Number</label>
                                <input type="text" name="ownerPhone" class="form-control" maxlength="10"
                                    placeholder="Enter phone number" required>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="" class="form-label">Owner Email</label>
                                <input type="email" name="ownerEmail" class="form-control" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-4 mt-2">
                                <label for="" class="form-label required px-1">User Name</label>
                                <input type="text" name="userName" class="form-control" placeholder="Enter user name"
                                    autocomplete="off">
                            </div> --}}
                            <div class="col-md-4 mt-2">
                                <label for="" class="form-label required">Password</label>
                                <input type="password" name="pwd" class="form-control" placeholder="Enter password"
                                    autocomplete="new-password">
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="" class="form-label required">Confirm Password</label>
                                <input type="password" name="ConPwd" class="form-control" placeholder="Enter password"
                                    autocomplete="new-password">
                            </div>
                        </div>
                        <div class="float-end mt-4">
                            <button type="submit" class="btn btn-primary" id="addVendor1">Save</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">View Vendor Details</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body details">
                    <div id="details" style="min-height:180px!important;">

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Password Reset -->
    <div class="modal fade bd-example-modal-xl" id="passwordReset" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog default modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0 text-success" id="myLargeModalLabel"><i class="fas fa-lock"></i> Change
                        Password</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="resetPasswordModalBtn"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $('document').ready(function() {
            $('#btnUploadImg').click(function() {
                $('#imgFile').click();
            });

            const width = 240;
            const height = 240;

            // check max upload file size
            function isValidFileSize(target) {

                var maxUploadSize = "{{ Config::get('constants.max_upload_file_size.in_byte', 2048000) }}";
                var maxUploadSizeMB = "{{ Config::get('constants.max_upload_file_size.in_mb', 2) }}";

                if (target.files[0].size > maxUploadSize) {
                    target.value = "";
                    alert("Maximum file size supported is " + maxUploadSizeMB + " MB");
                    return false;
                };

                return true;
            }
            // image preview
            $('#imgFile').change(function() {
                if (!isValidFileSize(this)) {
                    return;
                }
                var src = URL.createObjectURL(this.files[0]);
                $('#imgHolder').html('<img src="' + src + '" style="max-width: ' + width +
                    'px; max-height: ' + height + 'px;"/>');
            });


            $('.avl').change(function(e) {
                let avail = $(this).val();
                if (avail == 'yes') {
                    $('.dist').removeClass('d-none');
                } else {
                    $('.dist').addClass('d-none');
                }
            });

            $(document).on("click", ".del", function() {
                let vendorId = $(this).data('id');
                // alert(vendorId);
                var result = confirm("Do you want to delete this data?");
                if (result) {
                    $.ajax({
                        url: "{{ url('admin/vendor?action=delete-vendor') }}",
                        type: 'post',
                        data: {
                            _token: "{{ csrf_token() }}",
                            vendorId: vendorId,
                        },
                        success: function(data) {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        }

                    });
                }
            });

            $(document).on("click", ".viewDetails", function() {
                let vendorId = $(this).attr('data-id');
                $('#details').html('<h5 class="text-center">Please wait...</h5>')

                var url = "{{ url('admin/vendor?action=vendor-details-by-id') }}";

                $.get(url + "&vendorId=" + vendorId,
                    function(data) {
                        $('#details').html(data.html);
                    });
            });

            $("#paginationBox").pxpaginate({
                currentpage: {{ $vendorData->currentPage() }},
                totalPageCount: {{ ceil($vendorData->total() / $vendorData->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/vendor?action=all-vendor-list&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });

            $('#addVendor').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#addVendor1");

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
                            alert(data.message);
                        } else {
                            alert(data.message);
                            location.reload();
                            // window.location.replace("{!! url('franchise/student?action=add-student-qualification&studentId=') !!}" + data.data) ;
                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Save');
                    }
                });

            });

            // Change Password Partials 
            $(document).on("click", ".resetPasswordBtn", function() {
                let vendorId = $(this).attr('data-id');
                $('#resetPasswordModalBtn').html('<h5 class="text-center">Please wait...</h5>')

                var url = "{{ url('admin/vendor?action=vendor-change-password') }}";

                $.get(url + "&vendorId=" + vendorId,
                    function(data) {
                        $('#resetPasswordModalBtn').html(data.html);
                    });
            });


            // Active Vendor
            $(document).on('click', '.activeVendor', function(e) {
                var vendorId = $(this).data('id');

                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to Active Vendor !');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('admin/vendor') }}",
                        type: "POST",
                        data: {
                            action: 'active-vendor',
                            _token: "{{ csrf_token() }}",
                            vendor_id: vendorId
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


            // DeActive Vendor
            $(document).on('click', '.deactiveVendor', function(e) {
                var vendorId = $(this).data('id');

                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to DeActive Vendor !');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('admin/vendor') }}",
                        type: "POST",
                        data: {
                            action: 'deactive-vendor',
                            _token: "{{ csrf_token() }}",
                            vendor_id: vendorId
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
