@extends('public.layout')
@section('title', 'Product-details')
@section('custom-css')
    
@endsection
@section('body')

    <style>
        .required:after {
            content: " *";
            color: red;
        }

        .product__details__tab {
            /* margin-top: 80px; */
            /* margin-bottom: 65px; */
            margin: 40px 16% !important;
            padding: 20px !important;
            border: 1px solid #ddd;
            background: #f2f2f2;
        }

        @media screen and (max-width:575px) {
            .product__details__tab {
                margin: 0 !important;
            }
        }

        .nav {
            border-bottom: none;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            position: relative;
            margin-bottom: 40px;
        }

        .nav-item {
            margin-right: 46px;
        }

        .nav-item:last-child {
            margin-right: 0;
        }

        .nav-item .nav-link {
            font-size: 18px;
            color: #666666;
            text-transform: uppercase;
            font-weight: 600;
            border: none;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            padding: 0;
        }

        @media screen and (max-width:550px) {
            .nav-item .nav-link {
                font-size: 15px;
                text-transform: uppercase;
                font-weight: 600;
            }
        }

        .nav-item .nav-link.active {
            color: #ff5f00;
            font-weight: 600;
            background: none;
        }

        .tab-content .tab-pane h6 {
            color: #666666;
            font-weight: 600;
            margin-bottom: 24px;
            font-size: 18px;
        }

        .tab-content .tab-pane p:last-child {
            margin-bottom: 0;
        }

        .related__title h5 {
            font-size: 20px;
            color: #111111;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 35px;
        }
    </style>
    <!-- PRODUCT DETAILS SECTION STARTS -->

    <section class="product-details spad" style="margin-top:150px">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <img src="{{ asset('assets/uploads/product-image/' . $productData->product_images) }}"
                            alt="" width="60%">
                    </div>
                    <div class="product__details__text">
                        <h3 class="fw-bold">{{ $productData->product_name }}</h3>

                        <h5 class="mt-4 fw-bold mb-3">Opening Hours:</h5>
                        <ul>
                            <li><span class="fw-bold">Monday :</span>
                                {{ date('H:i A', strtotime($vendorTiming->monday_opening)) }} -
                                {{ date('h:i A', strtotime($vendorTiming->monday_closing)) }}</li>
                            <li><span class="fw-bold">Tuesday :</span>
                                {{ date('h:i A', strtotime($vendorTiming->tuesday_opening)) }} -
                                {{ date('h:i A', strtotime($vendorTiming->tuesday_closing)) }}</li>
                            <li><span class="fw-bold">Wednesday
                                    :</span>{{ date('h:i A', strtotime($vendorTiming->wednesday_opening)) }} -
                                {{ date('h:i A', strtotime($vendorTiming->wednesday_closing)) }}</li>
                            <li><span class="fw-bold">Thursday :</span>
                                {{ date('h:i A', strtotime($vendorTiming->thursday_opening)) }} -
                                {{ date('h:i A', strtotime($vendorTiming->thursday_closing)) }}</li>
                            <li><span class="fw-bold">Friday :</span>
                                {{ date('h:i A', strtotime($vendorTiming->friday_opening)) }} -
                                {{ date('h:i A', strtotime($vendorTiming->friday_closing)) }}</li>
                            <li><span class="fw-bold">Saturday :</span>
                                {{ date('h:i A', strtotime($vendorTiming->saturday_opening)) }} -
                                {{ date('h:i A', strtotime($vendorTiming->saturday_closing)) }}</li>
                            <li><span class="fw-bold">Sunday :</span>
                                {{ date('h:i A', strtotime($vendorTiming->sunday_opening)) }} -
                                {{ date('h:i A', strtotime($vendorTiming->sunday_closing)) }}</li>
                        </ul>
                        <div class="store__location mt-5">
                            <h5 class="fw-bold">Store Location :</h5>
                            <h6>{{ $productData->address }}</h6>
                            <div class="store__banner">
                                <div class="store__banner__image">
                                    <img src="{{ asset('assets/img/section-images/johnbike.png') }}" alt="ss">
                                </div>
                                <div class="store__banner__contents">
                                    <h4>{{ $productData->store_name }}</h4>
                                </div>

                            </div>
                        </div>
                        <div class="store__banner__categories">
                            <p>CATEGORIES :
                                @if (count($catNames) > 0)
                                    @if (count($catNames) > 1 && count($catNames) < 2)
                                        <span class="fw-bold"> {{ $catNames[0] }}</span>
                                    @else
                                        <span class="fw-bold"> {{ implode(',', $catNames) }}</span>
                            </p>
                            @endif
                        @else
                            <span class="fw-bold">No categories found!</span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <form action="{{ url('bike?action=book-now') }}" method="POST" id="booknowForm">
                        @csrf
                        <input type="hidden" name="priceingPlanId" id="pricingPalneId" value="">
                        <div class="product__details__dateTime">
                            <div class="product__details__price">
                                <h5 class="">Product Price :</h5>

                                <div class="product__price__categories">
                                    <div class="row">
                                        @foreach ($productAttrData as $data)
                                            <a type="button" class="col-md-3">
                                                <div class="product__price__categories__box"
                                                    data-pricingPlanId="{{ $data->pricingPlanId }}"
                                                    data-unit="{{ $data->pricing_plan_unit }}"
                                                    id="{{ $data->pricing_plan_unit }}">
                                                    <h3>
                                                        @if ($data->pricing_plan_unit == 'hour')
                                                            Hour
                                                        @elseif($data->pricing_plan_unit == 'day')
                                                            Day
                                                        @elseif($data->pricing_plan_unit == 'week')
                                                            Week
                                                        @else
                                                            Month
                                                        @endif
                                                    </h3>
                                                    <p>
                                                        @if(!empty($productData->discount))

                                                            <del class="text-secondary"><small>{{ $data->currency }} {{ $data->price }}</small></del> <br>

                                                            @if($productData->discount_type == 'flat')

                                                            <span>{{ $data->currency }} {{ $data->price-$productData->discount }}</span>


                                                            @else 
                                                            <span>{{ $data->currency }} {{ $data->price-($data->price*($productData->discount/100)) }}</span>

                                                            @endif

                                                        @else
                                                            {{ $data->currency }} {{ $data->price }}

                                                        @endif
                                                    </p>

                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="product__details__date">
                                <div class="row">
                                    <h5 class="fw-bold mb-3">Time :</h5>
                                    <div class="col-md-6">
                                        <label for="name" class="text-black mb-2 mt-2">Pickup Date <span
                                                style="color:#ff5f00;font-weight:600;">
                                                *</span> </label>

                                        <input class="form-control shadow-none pickup-date datepicker" id="date"
                                            name="pickup_date" type="text" value="" aria-label=""
                                            placeholder="Pickup date" style="border-radius: 16px;" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="text-black mb-2 mt-2">Pickup Time <span
                                                style="color:#ff5f00;font-weight:600;">*</span> </label>
                                        <input class="form-control shadow-none pickup-time" name="pickup_time"
                                            type="time" value="" aria-label="" style="border-radius: 16px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name" class="text-black mb-2 mt-2">Return Date <span
                                                style="color:#ff5f00;font-weight:600;">*</span> </label>
                                        <input class="form-control shadow-none return-date datepicker" name="return_date"
                                            type="text" value="" aria-label="" placeholder="Return Date"
                                            style="border-radius: 16px;" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="text-black mb-2 mt-2">Return Time <span
                                                style="color:#ff5f00;font-weight:600;">*</span> </label>
                                        <input class="form-control shadow-none return-time" name="return_time"
                                            type="time" value="" aria-label="" style="border-radius: 16px;">
                                    </div>
                                    <span id="cost"> </span>
                                </div>
                            </div>
                        </div>
                        <div class="product__details__equipments">
                            @if (count($productAttribute) > 0)
                                <h5 class="fw-bold mb-3">Extra Equipments :</h5>

                                <div class="row">
                                    @foreach ($productAttribute as $data)
                                        <div class="col-md-3 p-3 bg-light">
                                            <div class="custom-control custom-checkbox image-checkbox">
                                                <input type="checkbox" name="productAttrId[]"
                                                    value="{{ $data->id }}" class="custom-control-input"
                                                    id="ck1a">
                                                <input type="hidden" name="attrPrice[]" value="{{ $data->price }}">
                                                <label class="custom-control-label" for="ck1a">
                                                    <img src="{{ asset('assets/uploads/product-image') . '/' . $data->product_thumbnail }}"
                                                        style="height:70%;width:70%;border-radius:30%" alt="#"
                                                        class="img-fluid">
                                                </label>
                                                <p class="px-3 fw-bold mt-2">{{ $data->product_name }} <br>
                                                    {{ $data->price }} {{ $data->currency }}</p>
                                                <p></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        @if (session()->has('user_name'))
                            <div class="mt-3">
                                <input type="checkbox" name="terms" id="terms" required> I
                                Agree Terms & Coditions.
                            </div>
                            <div>
                                <a type="button" class="text-dark mt-2" href="{{url('/terms-and-conditions')}}"><i>Terms And Condition</i></a>
                            </div>
                            <div class="booknow__button">
                                <input type="hidden" name="vendor_id" value="{{ $productData->vendor_id }}">
                                <input type="hidden" name="product_id" value="{{ $productData->id }}">

                                <button type="submit" class="text-center d-block btn btn-disabled" id="btnsubmit"
                                    disabled>BOOK
                                    NOW</button>
                            </div>
                        @else
                            <div class="booknow__button">
                                <a href="{{ url('/login') }}" class="text-center d-block">LOGIN AND BOOK NOW</a>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>


    <!-- Nav tabs -->
    <div class="product__details__tab">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#description">Attributes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#specification">Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#review">Review(05)</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active container" id="description">
                <h6>Attributes</h6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere beatae impedit aliquid exercitationem
                    omnis nostrum porro culpa error. Minima, maxime nobis! Id nesciunt officia, a neque expedita voluptate
                    sint incidunt explicabo eligendi perferendis aliquid odit! Harum, qui deleniti eum quod velit iste nam
                    praesentium corrupti, minima, id possimus soluta. Totam eum, veniam rerum beatae officia possimus ullam
                    debitis deserunt non maxime qui tempora molestiae doloremque quod! Magni dolorum nemo delectus rerum?
                    Enim voluptatum expedita ipsam odio ab optio quisquam, quos, alias placeat perferendis fuga delectus
                    iusto hic cum ratione mollitia ad, possimus voluptate laboriosam. Consequatur eum natus doloribus
                    aliquid explicabo.</p>
            </div>
            <div class="tab-pane container" id="specification">
                <h6>Features</h6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere beatae impedit aliquid exercitationem
                    omnis nostrum porro culpa error. Minima, maxime nobis! Id nesciunt officia, a neque expedita voluptate
                    sint incidunt explicabo eligendi perferendis aliquid odit! Harum, qui deleniti eum quod velit iste nam
                    praesentium corrupti, minima, id possimus soluta. Totam eum, veniam rerum beatae officia possimus ullam
                    debitis deserunt non maxime qui tempora molestiae doloremque quod! Magni dolorum nemo delectus rerum?
                    Enim voluptatum expedita ipsam odio ab optio quisquam, quos, alias placeat perferendis fuga delectus
                    iusto hic cum ratione mollitia ad, possimus voluptate laboriosam. Consequatur eum natus doloribus
                    aliquid explicabo.</p>

            </div>
            <div class="tab-pane container" id="review">
                <h6>Review</h6>
                <p>All review will visible here...</p>

            </div>
        </div>
    </div>

    <!-- PRODUCT DETAILS SECTION ENDS -->
@endsection
@section('custom-js')
   
    <script>
        $(document).ready(function() {

            $('#terms').on('change', function() {
                // From the other examples
                if (!this.checked) {
                    $('#btnsubmit').addClass('btn btn-disabled');
                    $('#btnsubmit').attr('disabled', true);
                } else {
                    $('#btnsubmit').removeClass('btn btn-disabled');
                    $('#btnsubmit').attr('disabled', false);
                }
            });


            $('.product__price__categories__box').click(function() {
                let unit = $(this).attr('data-unit');
                // alert(unit);
                let planId = $(this).attr('data-pricingPlanId');
                $('#pricingPalneId').val(planId);
                if (unit == 'hour') {
                    $('#month').removeClass('bg-info');
                    $('#day').removeClass('bg-info');
                    $('#week').removeClass('bg-info');
                    $(this).addClass('bg-info');


                } else if (unit == 'day') {
                    $('#hour').removeClass('bg-info');
                    $('#week').removeClass('bg-info');
                    $('#month').removeClass('bg-info');
                    $(this).addClass('bg-info');
                } else if (unit == 'week') {
                    $('#day').removeClass('bg-info');
                    $('#week').removeClass('bg-info');
                    $('#month').removeClass('bg-info');
                    $(this).addClass('bg-info');
                } else {
                    $('#hour').removeClass('bg-info');
                    $('#week').removeClass('bg-info');
                    $('#day').removeClass('bg-info');
                    $(this).addClass('bg-info');
                }
            });
            $('#booknowForm').submit(function(e) {
                e.preventDefault();

                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var formData = new FormData(this);
                var error = $('.error');

                error.text("");

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btnsubmit').text("Please wait ...").attr('disabled', true);
                    },
                    success: function(data) {
                        // alert message
                        if (!data.success) {
                            alert(data.message);
                        } else {
                            alert(data.message);

                            window.location.replace(
                                "{!! url('bike?action=my-booking&productId=') !!}" + data.data);
                        }
                    },
                    complete: function() {
                        $('#btnsubmit').text("BOOK NOW").attr('disabled', false);
                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            // var array = ["2023-04-04", "2023-04-06", "2023-04-08"];
            var array = [{!! $blockDates !!}];
            var dateToday = new Date();

            $(".datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                minDate: dateToday,
                beforeShowDay: function(date) {
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [array.indexOf(string) == -1]
                }
            });

        })
    </script>
    <script>
        // Select all tabs
        $('.nav-tabs a').click(function() {
            $(this).tab('show');
        })

        // Select tab by name
        $('.nav-tabs a[href="#home"]').tab('show')

        // Select first tab
        $('.nav-tabs a:first').tab('show')

        // Select last tab
        $('.nav-tabs a:last').tab('show')

        // Select fourth tab (zero-based)
        $('.nav-tabs li:eq(3) a').tab('show')
    </script>

@endsection
