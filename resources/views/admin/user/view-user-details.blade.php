@extends('admin.layout', [
    'pageTitle' => 'User Details',
    'currentPage' => 'userlist',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">User Details</li>
@endsection

@section('custom-css')
@endsection

@section('body')

    <div class="col-lg-12 col-xl-12">
        <a href="{{ url('admin/user?action=user-list') }}" class="btn btn-primary mb-2" type="button"><i
                class="fas fa-arrow-alt-circle-left"></i> Back</a>
        @if (count($allBookingData) > 0)
            <div class="card">
                <input type="hidden" name="id" value="{{ $userData->id }}">
                <div class="card-header">
                    <h4 class="card-title">{{ $userData->name }}</h4>
                </div>
                <!--end card-header-->
                <div class="card-body">

                    <!-- Nav tabs -->
                    <div class="nav-tabs-custom text-center">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-center active" data-bs-toggle="tab" href="#booking_details"
                                    role="tab" aria-selected="false"><i class="fab fa-product-hunt d-block"></i>Booking
                                    Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center" data-bs-toggle="tab" href="#user_details" role="tab"
                                    aria-selected="false"><i class="fas fa-user-tie d-block"></i>User Details</a>
                            </li>
                            {{-- <li class="nav-item">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#cu_settings" role="tab"
                                aria-selected="true"><i class="la la-cog d-block"></i>Setings</a>
                        </li> --}}
                        </ul>
                    </div>
                    <hr>

                    <div class="tab-content">
                        <!-- Start Booking Details -->

                        <div class="tab-pane p-3 active" id="booking_details" role="tabpanel">
                            <p class="mb-0 text-muted">
                                @if (count($allBookingData) > 0)
                                    @foreach ($allBookingData as $data)
                                        <div class="list-group">
                                            <li type="button" class="list-group-item card ordercardli">
                                                <a class="viewProductBtn" data-id="{{ $data->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#userProductDetailsModal">
                                                    <div class="row g-3">
                                                        <img src="{{ asset('assets/uploads/product-image') . '/' . $data->product_thumbnail }}"
                                                            class="col-sm-1" width="80px" height="70px">
                                                        <div class="col-md-3">{{ $data->product_name }}</div>
                                                        <div class="col">
                                                            {{ $data->currency }}
                                                            <span>
                                                                {{ $data->product_price }}.00
                                                            </span>
                                                        </div>

                                                        {{-- <div class="col"><span></span></div> --}}
                                                        <div class="col-md-3">
                                                            @if ($data->status == 'pending')
                                                                <span class="badge badge-soft-warning">Pending</span>
                                                            @elseif($data->status == 'canceled')
                                                                <span class="badge badge-soft-danger">Canceled</span>
                                                            @elseif($data->status == 'approved')
                                                                <span class="badge badge-soft-success">Approved</span>
                                                            @elseif($data->status == 'rejected')
                                                                <span class="badge badge-soft-danger">Rejected</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-3"><i class="fas fa-clock"></i>
                                                            Order At :<span
                                                                class="text-success">{{ date('d M, Y, G:i A', strtotime($data->created_at)) }}</span>
                                                        </div>

                                                    </div>
                                                </a>
                                            </li>
                                        </div>
                                    @endforeach
                                    <div id="paginationBox" class="my-5"></div>
                                @else
                                    <h4 class="text-center text-danger mt-4 p-4">No Record Found !</h4>
                                @endif
                               
                            </p>
                        </div>
                        <!-- End Booking Details -->

                        <!-- Start User Details -->
                        <div class="tab-pane p-3" id="user_details" role="tabpanel">
                            <p class="mb-0 text-muted">
                            <div id="details" style="min-height:250px!important;">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered table-responsive">
                                                    <tbody>
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>{{ $userData->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone No</th>
                                                            <td>{{ $userData->phone }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email</th>
                                                            <td>{{ $userData->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address Line One</th>
                                                            <td>
                                                                @if ($userData->address01 > 0)
                                                                    {{ $userData->address01 }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address Line Two</th>
                                                            <td>
                                                                @if ($userData->address02 > 0)
                                                                    {{ $userData->address02 }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Account Create Date</th>
                                                            <td>{{ date('d M, Y, G:i A', strtotime($userData->created_at)) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Is Active</th>
                                                            <td>
                                                                @if ($userData->is_active == 1)
                                                                    <span class="badge badge-soft-success">Active</span>
                                                                @elseif($userData->is_active == 0)
                                                                    <span class="badge badge-soft-danger">Deactivate</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-2" style="border-radius: 10%">
                                            <div class="card-body text-center">
                                                <div class="mb-2" id="imgHolder" style="min-height: 120px;">
                                                    @if ($userData->profile_pic != null)
                                                        <img src="{{ asset('assets/uploads/profile_picture_user') . '/' . $userData->profile_pic }}"
                                                            class="rounded-circle" width="40%" height="100px">
                                                    @else
                                                        <img src="{{ asset('assets/images/profile.png') }}"
                                                            class="rounded-circle" width="40%" height="100px">
                                                    @endif

                                                </div>
                                                <h5>Profile Picture</h5>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h4 class="text-center text-danger mt-4 p-4">No Record Available !</h4>

        @endif


    </div>


    <!--Start User Product Details Partials-->
    <div class="modal fade bd-example-modal-xl" id="userProductDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="userProductDetailsModal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">View Product Details</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body details">
                    <div id="detailsPartialsBtn" style="min-height: 300px">
                    </div>
                    <div class="float-end">
                        <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End User Product Details Partials-->
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // User Product Details Partials
            $(document).on("click", ".viewProductBtn", function() {
                let productId = $(this).attr('data-id');
                $('#detailsPartialsBtn').html('<h5 class="text-center">Please wait...</h5>')

                var url = "{{ url('admin/user?action=user-product-details') }}";

                $.get(url + "&id=" + productId,
                    function(data) {
                        $('#detailsPartialsBtn').html(data.html);
                    });
            });

            // Pagination
            $("#paginationBox").pxpaginate({
                currentpage: {{ $allBookingData->currentPage() }},
                totalPageCount: {{ ceil($allBookingData->total() / $allBookingData->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var u = "{!! url('admin/user?action=user-details&id=') !!}";
                   var url = u + {{$id}} + '&page=' + pagenumber;
                    window.location.replace(url);
                },
            });
        });
    </script>
@endsection
