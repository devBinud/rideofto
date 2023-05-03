@extends('admin.layout', [
    'pageTitle' => 'Booking List',
    'currentPage' => 'bookinglist',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Booking List</li>
@endsection

@section('custom-css')
@endsection

@section('body')

    <div class="col-lg-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <div class="nav-tabs-custom text-center">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link text-center active" data-bs-toggle="tab" href="#pending_order" role="tab">
                                <img src="{{ asset('assets/booking-icon/pending.png') }}" width="30px" height="30px">
                                <br>
                                <span class="text-warning">Pending</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#approved_order" role="tab"> <img
                                    src="{{ asset('assets/booking-icon/approved.png') }}" width="30px" height="30px">
                                <br><span class="text-success">Approved</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#cancel_order" role="tab"><img
                                    src="{{ asset('assets/booking-icon/cancelled.png') }}" width="30px" height="30px">
                                <br><span class="text-danger">Cancel</span></a>
                        </li>
                    </ul>
                </div>


                <!-- Tab panes -->
                <div class="tab-content">
                    <!--Start Pending Order table-->
                    <div class="tab-pane active p-3" id="pending_order" role="tabpanel">
                        <p class="mb-0 text-muted">
                        <div class="card">
                            <div class="card-body">
                                @if (count($bookinglist) > 0)
                                    <div class="table table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead class="bg-secondary">
                                                <th>#</th>
                                                <th>Product Image</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Order Status</th>
                                                <th>Order At</th>
                                                <th>Customer Details</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($bookinglist as $data)
                                                    @if ($data->status == 'pending')
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>
                                                                <a target="_blank"
                                                                    href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}">
                                                                    <img src="{{ asset('assets/uploads/product-image') . '/' . $data->product_thumbnail }}"
                                                                        class="rounded-circle" width="50px"
                                                                        height="50px">
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a target="_blank"
                                                                    href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}">
                                                                    {{ $data->product_name }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                {{ $data->currency }}
                                                                <span>{{ $data->product_price }}.00</span>
                                                            </td>
                                                            <td>
                                                                @if ($data->status == 'pending')
                                                                    <span class="badge badge-soft-warning">Pending</span>
                                                                @elseif($data->status == 'canceled')
                                                                    <span class="badge badge-soft-danger">Canceled</span>
                                                                @elseif($data->status == 'approved')
                                                                    <span class="badge badge-soft-success">Approved</span>
                                                                @elseif($data->status == 'rejected')
                                                                    <span class="badge badge-soft-danger">Rejected</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ date('d M, Y, G:i A', strtotime($data->created_at)) }}
                                                            </td>
                                                            <td>
                                                                {{ $data->name }}
                                                                <br>
                                                                <span class="text-muted font-13">{{ $data->phone }}</span>
                                                                <br>
                                                                <span class="text-muted font-13">{{ $data->email }}</span>

                                                            </td>
                                                            <td>
                                                                <a target="_blank"
                                                                    href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}"
                                                                    class="tippy-btn px-1">
                                                                    <i class="" data-feather="eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="paginationBox" class="my-2"></div>
                                @else
                                    <h4 class="text-center text-danger mt-4 p-4">No Record Found !</h4>
                                @endif
                            </div>
                        </div>
                        </p>
                    </div>
                    <!--End Pending Order table-->


                    <!--Start Approved Order Table-->
                    <div class="tab-pane p-3" id="approved_order" role="tabpanel">
                        <p class="mb-0 text-muted">
                        <div class="card">
                            <div class="card-body">
                                @if (count($bookinglist) > 0)
                                    <div class="table table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead class="bg-secondary">
                                                <th>#</th>
                                                <th>Product Image</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Order Status</th>
                                                <th>Order At</th>
                                                <th>Customer Details</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($bookinglist as $data)
                                                    @if ($data->status == 'approved')
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>
                                                                <a href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}"
                                                                    target="_blank" rel="noopener noreferrer">
                                                                    <img src="{{ asset('assets/uploads/product-image') . '/' . $data->product_thumbnail }}"
                                                                        class="rounded-circle" width="50px"
                                                                        height="50px">
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}"
                                                                    target="_blank" rel="noopener noreferrer">
                                                                    {{ $data->product_name }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                {{ $data->currency }}
                                                                <span>{{ $data->product_price }}.00</span>
                                                            </td>
                                                            <td>
                                                                @if ($data->status == 'pending')
                                                                    <span class="badge badge-soft-warning">Pending</span>
                                                                @elseif($data->status == 'canceled')
                                                                    <span class="badge badge-soft-danger">Canceled</span>
                                                                @elseif($data->status == 'approved')
                                                                    <span class="badge badge-soft-success">Approved</span>
                                                                @elseif($data->status == 'rejected')
                                                                    <span class="badge badge-soft-danger">Rejected</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ date('d M, Y, G:i A', strtotime($data->created_at)) }}
                                                            </td>
                                                            <td>
                                                                {{ $data->name }}
                                                                <br>
                                                                <span class="text-muted font-13">{{ $data->phone }}</span>
                                                                <br>
                                                                <span class="text-muted font-13">{{ $data->email }}</span>

                                                            </td>
                                                            <td>
                                                                <a target="_blank"
                                                                    href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}"
                                                                    class="tippy-btn px-1">
                                                                    <i class="" data-feather="eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="paginationBox" class="my-2"></div>
                                @else
                                    <h4 class="text-center text-danger mt-4 p-4">No Record Found !</h4>
                                @endif
                            </div>
                        </div>
                        </p>
                    </div>
                    <!--End Approved Order Table-->


                    <!--Start Cancel Order Table-->
                    <div class="tab-pane p-3" id="cancel_order" role="tabpanel">
                        <p class="text-muted mb-0">
                        <div class="card">
                            <div class="card-body">
                                @if (count($bookinglist) > 0)
                                    <div class="table table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead class="bg-secondary">
                                                <th>#</th>
                                                <th>Product Image</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Order Status</th>
                                                <th>Order At</th>
                                                <th>Customer Details</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($bookinglist as $data)
                                                    @if ($data->status == 'canceled')
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>
                                                                <a href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}"
                                                                    target="_blank" rel="noopener noreferrer">
                                                                    <img src="{{ asset('assets/uploads/product-image') . '/' . $data->product_thumbnail }}"
                                                                        class="rounded-circle" width="50px"
                                                                        height="50px">
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}"
                                                                    target="_blank" rel="noopener noreferrer">
                                                                    {{ $data->product_name }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                {{ $data->currency }}
                                                                <span>{{ $data->product_price }}.00</span>
                                                            </td>
                                                            <td>
                                                                @if ($data->status == 'pending')
                                                                    <span class="badge badge-soft-warning">Pending</span>
                                                                @elseif($data->status == 'canceled')
                                                                    <span class="badge badge-soft-danger">Canceled</span>
                                                                @elseif($data->status == 'approved')
                                                                    <span class="badge badge-soft-success">Approved</span>
                                                                @elseif($data->status == 'rejected')
                                                                    <span class="badge badge-soft-danger">Rejected</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ date('d M, Y, G:i A', strtotime($data->created_at)) }}
                                                            </td>
                                                            <td>
                                                                {{ $data->name }}
                                                                <br>
                                                                <span
                                                                    class="text-muted font-13">{{ $data->phone }}</span>
                                                                <br>
                                                                <span
                                                                    class="text-muted font-13">{{ $data->email }}</span>

                                                            </td>
                                                            <td>
                                                                <a target="_blank"
                                                                    href="{{ url('admin/user?action=view-booking-details&product_id=' . $data->product_id) }}"
                                                                    class="tippy-btn px-1">
                                                                    <i class="" data-feather="eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="paginationBox" class="my-2"></div>
                                @else
                                    <h4 class="text-center text-danger mt-4 p-4">No Record Found !</h4>
                                @endif
                            </div>
                        </div>
                        </p>
                    </div>
                    <!--End Cancel Order Table-->


                </div>
                <!--end tab-content-->
            </div>
            <!--end card-body-->
        </div>

    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Pagination
            $("#paginationBox").pxpaginate({
                currentpage: {{ $bookinglist->currentPage() }},
                totalPageCount: {{ ceil($bookinglist->total() / $bookinglist->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/user?action=booking-list&page=') !!}" + pagenumber;
                    window.location.replace(url);
                },
            });
        });
    </script>
@endsection
