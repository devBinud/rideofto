@extends('admin.layout', [
    'pageTitle' => 'View Booking Details',
    'currentPage' => 'bookingDetails',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">View Booking Details</li>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <input type="hidden" name="product_id" value="{{ $bookingDetailsData->product_id }}">

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 align-self-center">
                            <img src="{{ asset('assets/uploads/product-image') . '/' . $bookingDetailsData->product_thumbnail }}"
                                class=" mx-auto  d-block" height="300">
                        </div>
                        <!--end col-->

                        <!--Start Product Details-->
                        <div class="col-lg-6 align-self-center">
                            <div class="single-pro-detail">
                                <p class="mb-1">Product Details</p>
                                <div class="custom-border mb-3"></div>
                                <h3 class="pro-title">{{ $bookingDetailsData->product_name }}</h3>
                                <p class="text-muted mb-0">{!! $bookingDetailsData->product_description !!}</p>
                                <h3 class="pro-title">{{ $bookingDetailsData->currency }}
                                    <span>
                                        {{ $bookingDetailsData->product_price }}.00
                                    </span>
                                </h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name" class="text-black mb-2 mt-2">Pickup Date </label>
                                        <span class="form-control shadow-none pickup-date" name="pickup_date" type="date"
                                            value="" aria-label="" placeholder="Pickup Date"
                                            style="border-radius: 16px;">
                                            {{ date('d M, Y', strtotime($bookingDetailsData->pickup_date)) }}
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="text-black mb-2 mt-2">Pickup Time </label>
                                        <span class="form-control shadow-none pickup-date" name="pickup_date" type="date"
                                            value="" aria-label="" placeholder="Pickup Date"
                                            style="border-radius: 16px;">
                                            {{ date('G:i A', strtotime($bookingDetailsData->pickup_time)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name" class="text-black mb-2 mt-2">Return Date </label>
                                        <span class="form-control shadow-none pickup-date" name="pickup_date" type="date"
                                            value="" aria-label="" placeholder="Pickup Date"
                                            style="border-radius: 16px;">
                                            {{ date('d M, Y', strtotime($bookingDetailsData->return_date)) }}
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="text-black mb-2 mt-2">Return Time </label>
                                        <span class="form-control shadow-none pickup-date" name="pickup_date" type="date"
                                            value="" aria-label="" placeholder="Pickup Date"
                                            style="border-radius: 16px;">
                                            {{ date('G:i A', strtotime($bookingDetailsData->return_time)) }}
                                        </span>
                                    </div>
                                    <span id="cost"> </span>
                                </div>
                                <div class="radio2 radio-dark2 form-check-inline">
                                    <h5 class="fw-bold mb-3">Status :
                                        @if ($bookingDetailsData->status == 'pending')
                                            <span class="badge badge-soft-warning">Pending</span>
                                        @elseif($bookingDetailsData->status == 'canceled')
                                            <span class="badge badge-soft-danger">Canceled</span>
                                        @elseif($bookingDetailsData->status == 'approved')
                                            <span class="badge badge-soft-success">Approved</span>
                                        @elseif($bookingDetailsData->status == 'rejected')
                                            <span class="badge badge-soft-danger">Rejected</span>
                                        @endif
                                    </h5>

                                </div>
                            </div>
                        </div>
                        <!--End Product Details-->

                        <!--Start Vendor Details-->
                        <div class="col-lg-6 align-self-center">
                            <div class="single-pro-detail">
                                <p class="mb-1">Vendor Details</p>
                                <div class="custom-border mb-3"></div>
                                <h3 class="pro-title">{{ $bookingDetailsData->store_name }}</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name"
                                            class="text-black mb-2 mt-2">{{ $bookingDetailsData->store_phone }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name"
                                            class="text-black mb-2 mt-2">{{ $bookingDetailsData->store_email }} </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name"
                                            class="text-black mb-2 mt-2">{{ $bookingDetailsData->postal_code }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name"
                                            class="text-black mb-2 mt-2">{{ $bookingDetailsData->address }}</label>
                                    </div>
                                    <span id="cost"></span>
                                </div>
                            </div>
                        </div>
                        <!--End Vendor Details-->

                        <!--Start Customer Details-->
                        <div class="col-lg-6 align-self-center">
                            <div class="single-pro-detail">
                                <p class="mb-1">Customer Details</p>
                                <div class="custom-border mb-3"></div>
                                <h3 class="pro-title">{{ $bookingDetailsData->name }}</h3>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name"
                                                class="text-black mb-2 mt-2">{{ $bookingDetailsData->name }}</label>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name"
                                                class="text-black mb-2 mt-2">{{ $bookingDetailsData->phone }} </label>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name"
                                                class="text-black mb-2 mt-2">{{ $bookingDetailsData->email }}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name"
                                                class="text-black mb-2 mt-2">{{ $bookingDetailsData->address01 }}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name"
                                                class="text-black mb-2 mt-2">{{ $bookingDetailsData->address02 }} </label>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--Start Customer Details-->

                    </div>
                    <!--end row-->
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>

    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
@endsection
