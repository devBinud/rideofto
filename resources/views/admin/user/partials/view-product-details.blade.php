<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <img src="{{ asset('assets/uploads/product-image') . '/' . $productDetails->product_thumbnail }}"
                        class=" mx-auto  d-block" height="300">
                </div>
                <!--end col-->
                <div class="col-lg-6 align-self-center">
                    <div class="single-pro-detail">
                        <p class="mb-1">Vendor Store Name : {{ $productDetails->store_name }}</p>
                        <div class="custom-border mb-3"></div>
                        <h3 class="pro-title">{{ $productDetails->product_name }}</h3>
                        <p class="text-muted mb-0">{!! $productDetails->product_description !!}</p>
                        <h3 class="pro-title">{{ $productDetails->currency }}
                            <span>
                                {{ $productDetails->product_price }}.00
                            </span>
                        </h3>
                        {{-- <h2 class="pro-price">
                        </h2> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="text-black mb-2 mt-2">Pickup Date </label>
                                <span class="form-control shadow-none pickup-date" name="pickup_date" type="date"
                                    value="" aria-label="" placeholder="Pickup Date"
                                    style="border-radius: 16px;">
                                    {{ date('d M, Y', strtotime($productDetails->pickup_date)) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="text-black mb-2 mt-2">Pickup Time </label>
                                <span class="form-control shadow-none pickup-date" name="pickup_date" type="date"
                                    value="" aria-label="" placeholder="Pickup Date"
                                    style="border-radius: 16px;">
                                    {{ date('G:i A', strtotime($productDetails->pickup_time)) }}
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="text-black mb-2 mt-2">Return Date </label>
                                <span class="form-control shadow-none pickup-date" name="pickup_date" type="date"
                                    value="" aria-label="" placeholder="Pickup Date"
                                    style="border-radius: 16px;">
                                    {{ date('d M, Y', strtotime($productDetails->return_date)) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="text-black mb-2 mt-2">Return Time </label>
                                <span class="form-control shadow-none pickup-date" name="pickup_date" type="date"
                                    value="" aria-label="" placeholder="Pickup Date"
                                    style="border-radius: 16px;">
                                    {{ date('G:i A', strtotime($productDetails->return_time)) }}
                                </span>
                            </div>
                            <span id="cost"> </span>
                        </div>
                        <div class="radio2 radio-dark2 form-check-inline">
                            <h5 class="fw-bold mb-3">Status :
                                @if ($productDetails->status == 'pending')
                                    <span class="badge badge-soft-warning">Pending</span>
                                @elseif($productDetails->status == 'canceled')
                                    <span class="badge badge-soft-danger">Canceled</span>
                                @elseif($productDetails->status == 'approved')
                                    <span class="badge badge-soft-success">Approved</span>
                                @elseif($productDetails->status == 'rejected')
                                    <span class="badge badge-soft-danger">Rejected</span>
                                @endif
                            </h5>

                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end card-body-->
    </div>
    <!--end card-->
</div>
