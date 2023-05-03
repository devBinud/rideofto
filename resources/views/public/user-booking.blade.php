@extends('public.layout')
@section('title', 'Profile')
@section('custom-css')
@endsection
@section('body')

    <style>
        .features__user__profile__wrapper {
            margin: 10px 0;
            border-radius: 8px;
            padding: 20px 40px;
            background: #F5FBFF;
            margin-bottom:20px;
            box-shadow: 0 0 20px rgba(214, 215, 216, 0.5);
            border:1px solid #fbe1d2;
        }
        .features__user__profile__details{
            border: 1px solid #e9e8e8;
        }

        @media screen and (max-width:575px) {
            .features__user__profile__wrapper {
                padding: 6px 16px;
            }
            .features__user__profile__details{
               border: none;
        }
        }

        .features__user__profile__details__name h3 {
            font-size: 18px;
            margin-top: 10px;
            color:#44546d;
            font-weight:bold
        }
        .features__user__profile__details h3{
            font-size: 18px;
            margin-top: 10px;
            color:#44546d;
            font-weight:bold
        }
        .features__user__profile__details__name p{
            color:#44546d;
            font-weight:normal;
        }
        .card__card__box__header {
            margin: 20px;
            padding: 20px 0;
            border-bottom: 2px dotted #fbc09d;
        }

        @media screen and (max-width:575px) {
            .card__card__box__header {
                margin: 10px !important;
            }
        }

        .order__card__box__product__contents {
            margin-left: 20px;
        }




        input.star { display: none; }

        

        label.star {

            /* float: left; */

            /* padding: 10px; */

            font-size: 1.5rem;

            color: #4A148C;

            transition: all .2s;

        }

        

        input.star:checked ~ label.star:before {

        content: '\f005';

        color: #FD4;

        transition: all .25s;

        }

        
        input.star-5:checked ~ label.star:before {

        color: #FE7;

        text-shadow: 0 0 20px #952;

        }

        

        input.star-1:checked ~ label.star:before { color: #F62; }

            

        label.star:hover { transform: rotate(-15deg) scale(1.3); }

        

        label.star:before {

            content: '\f006';

            font-family: FontAwesome;

        }

        .rotate-180 {
            transform: rotate(180deg) ;
        }
    </style>
    <!-- USERS BOOKING SECTION STARTS -->


    <div id="user__profile" class="user__profile">
        <div class="container-fluid">
            <div class="col-md-12 mx-auto">
                <div class="pagetitle text-center p-5">
                    <!-- <img src="{{ asset('assets/img/logo/logo.png') }}" alt="" width="40"> -->
                    <h1 class="">My Profile</h1>
                </div>
                <!-- End Page Title -->


                <section id="features" class="features">
                    <div class="container" data-aos="fade-up">
                        <div class="features__users__profile">
                            <div class="features__user__profile__wrapper">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="features__user__profile__details" style="background: rgb(255, 253, 237);  padding: 30px;border-radius: 10px;display:flex;">
                                            <div class="features__user__profile__details__img me-3">
                                                <img src="@if ($userData->profile_pic == null) {{ asset('assets/img/section-images/profile.png') }} @else {{ asset('./assets/uploads/profile_picture_user/' . $userData->profile_pic) }} @endif"
                                                    alt="" style="border-radius: 30%" width="70">
                                                {{-- src="{{ asset('assets/img/section-images/profile.png') }}" --}}
                                            </div>
                                            <div class="features__user__profile__details__name">
                                                <h3>{{ $userData->name }}</h3>
                                                <p>
                                                    @if ($userData->address01 == null)
                                                        N/A
                                                    @else
                                                        {{ $userData->address01 }}
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="features__user__profile__details" style="background: rgb(243, 252, 243);  padding: 30px;border-radius: 10px;">
                                            <h3>Phone No : <span
                                                    style="color:#44546d;font-weight:normal;font-size:17px;">{{ $userData->phone }}</span>
                                            </h3>
                                            <h3 class="mt-3">Email : <span
                                                    style="color:#44546d;font-weight:normal;font-size:17px;">{{ $userData->email }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="features__user__profile__details" style="background: rgb(255, 253, 237);padding: 30px;border-radius: 10px;">
                                            <h3 class="fw-bold mt-2">Address 01: <span
                                                    style="color:#44546d;font-weight:normal;font-size:17px;">
                                                    @if ($userData->address01 == null)
                                                        N/A
                                                    @else
                                                        {{ $userData->address01 }}
                                                    @endif
                                                </span></h3>
                                            <h3 class="fw-bold mt-3">Address 02 :<span
                                                    style="color:#44546d;font-weight:normal;font-size:17px;">
                                                    @if ($userData->address02 == null)
                                                        N/A
                                                    @else
                                                        {{ $userData->address02 }}
                                                    @endif
                                                </span></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs row  g-2 d-flex">
                            @if(count($orderData) > 0)
                            <li class="nav-item col-6">
                                <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#tab-1">
                                    <h4>My Order</h4>
                                </a>
                            </li><!-- End tab nav item -->
                            @endif
                            <li class="nav-item col-6">
                                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-2">
                                    <h4>My Bookings</h4>
                                </a><!-- End tab nav item -->

                            <li class="nav-item col-6">
                                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-3">
                                    <h4>Account Details</h4>
                                </a>
                            </li><!-- End tab nav item -->

                        </ul>

                        <div class="tab-content">
                            @if(count($orderData) > 0)
                            <div class="tab-pane active show" id="tab-1">
                                <div class="order__card__wrapper">
                                    <div class="order__card__box">
                                        <div class="card__card__box__header">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="order__id">
                                                        <h4>Order Id :</h4>
                                                        <h4>{{ 'RIDEOF_' . $orderData[0]->id }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="order__date">
                                                        <h4>Placed</h4>
                                                        <h4>{{ date('d M,Y g:i A', strtotime($orderData[0]->created_at)) }}
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="order__bill">
                                                        <h4>Total</h4>
                                                        <h4>{{ $orderData[0]->booking_price }}
                                                            {{ $orderData[0]->currency }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order__card__box__status">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="order__status">
                                                        <h4>Order Status : <span
                                                                class="text-success fw-normal">{{ ucfirst($orderData[0]->status) }}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="order__place">
                                                        <h4>Delivered to : <span
                                                                class="text-success"> {{ $orderData[0]->name }} </span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order__card__box__products">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="order__card__box__product">
                                                        <div class="order__card__box__product__image">
                                                           
                                                            <img src="@if ($orderData[0]->product_images == null) {{ asset('assets/img/product-images/p1.jpg') }} @else {{ asset('assets/uploads/product-image') . '/' . $orderData[0]->product_images }} @endif"
                                                                alt="dd">
                                                            
                                                        </div>
                                                        <div class="order__card__box__product__contents">
                                                            <h6 class="product__title"> {{ $orderData[0]->product_name }}
                                                            </h6>
                                                            <h6 class="product__price">{{ $orderData[0]->booking_price }}
                                                                {{ $orderData[0]->currency }} </h6>
                                                            {{-- <h6>Quantity :1</h6> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="order__card__box__product__accessories">
                                                        @if(count($productAttr) > 0)
                                                        <h6 style="margin-left:38px;font-weight:600;">Accesories included
                                                        </h6>
                                                        
                                                        <ul>
                                                            @foreach ($productAttr as $p)
                                                                <li><i class="bi bi-check2 me-3"
                                                                        style="color:#ff5f00;font-weight:700;"></i>{{$p->product_name}} - {{$p->currency}}
                                                                    
                                                                    </li>
                                                               
                                                            @endforeach
                                                        </ul>
                                                        @else
                                                        <h6 style="margin-left:38px;font-weight:600;">No accesories included.
                                                        </h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order__card__box__moredetails">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="order__card__box__moredetails__vendor">
                                                    <h4>{{ $orderData[0]->store_name }} </h4>
                                                    <p>{{ $orderData[0]->address }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="order__card__box__moredetails__reportproblembutton">
                                                    <button>Report Problem</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End tab content item -->
                            @endif
                            <div class="tab-pane" id="tab-2">
                                <div class="booking__cards">
                                    <div class="card-body table-responsive">
                                        @if (count($data) > 0)
                                            <table class="table table-bordered table-hover text-center">
                                                <thead class="text-white" style="background:#ff5f00;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Booking ID</th>
                                                        <th>Store name</th>
                                                        <th>Pickup Date</th>
                                                        <th>Pickup Time</th>
                                                        <th>Return Date</th>
                                                        <th>Return Time</th>
                                                        {{-- <th>Distance</th> --}}
                                                        <th>Price</th>
                                                        <th>Status</th>

                                                    </tr>
                                                </thead>
                                                

                                                <tbody>
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td>{{ ++$sn }}</td>
                                                            <td>{{ 'RIDEOF_' . $item->id }}</td>
                                                            <td>{{ $item->store_name }}</td>
                                                            <td>{{ date('d M,Y', strtotime($item->pickup_date)) }}</td>
                                                            <td>{{ date('h:i A', strtotime($item->pickup_time)) }}</td>
                                                            <td>{{ date('d M,Y', strtotime($item->return_date)) }}</td>
                                                            <td>{{ date('h:i A', strtotime($item->return_time)) }}</td>
                                                            <td>{{ $item->booking_price }} {{ $item->currency }}</td>
                                                            <td>
                                                                
                                                                @if($item->status == 'approved')
                                                                <span class="badge bg-success p-2">Approved</span>

                                                                @if(empty($item->review_id))
                                                                    <span class="btn badge bg-warning p-2 review-btn" data-bs-toggle="modal" data-bs-target="#review" data-product = "{{ $item->product_id }}" data-booking = "{{ $item->id }}"><i class="fa fa-star"></i> Review</span>


                                                                @else 
                                                                    <span class="badge bg-success p-2">Review Submitted</span>

                                                                @endif

                                                                @elseif($item->status == 'pending')
                                                                <span class="badge bg-secondary p-2" >Pending</span>
                                                                <a data-id="{{$item->id}}" type="button" class="btn btn-primary btn-sm modalClick" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Cencel Booking</a>
                                                                @elseif($item->status == 'canceled')
                                                                <span class="badge bg-secondary p-2">Canceled</span>
                                                                @elseif($item->status == 'rejected')
                                                                <span class="badge bg-danger p-2">Rejected</span>
                                                              <a type="button" data-rejectreason="{{$item->reject_reason}}" class="btn btn-sm btn-info viewR" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">View Reason</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        @else
                                            <h4 class="text-center mt-4 p-4" style="color:#f4664f;font-size:16px;font-weight:bold">No booking history found!</h4>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- End tab content item -->

                            <div class="tab-pane" id="tab-3">
                                <div class="account__setting">
                                    <form action="{{ url('bike?action=my-booking') }}" method="POST"
                                        enctype="multipart/form-data" id="accDetails">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label fw-bold" style="color:#44546d">Profile
                                                Image</label>
                                            <div class="col-md-8 col-lg-9" style="display:flex;">
                                                <div id="imgHolder">
                                                  
                                                    <img id="rem"
                                                        src="@if ($userData->profile_pic == null) {{ asset('assets/img/section-images/profile.png') }} @else {{ asset('./assets/uploads/profile_picture_user/' . $userData->profile_pic) }} @endif"
                                                        alt="Profile" style="width:70px;height:70px; border-radius:50% !important;">
                                                </div>
                                                <div  class="px-3" style="margin-top:20px;">
                                                    <a type="button" class="btn btn-primary btn-sm"
                                                        title="Upload new profile image" id="btnUploadImg"><i
                                                            class="bi bi-upload"></i></a>
                                                    <input type="file" accept='image/jpeg,image/gif,image/png'
                                                        class="d-none" name="img_file" id="imgFile">
                                                    <input type="hidden" name="img_text" id="imgText">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label fw-bold" style="color:#44546d">Full
                                                Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fullName" type="text" class="form-control shadow-none"
                                                    id="fullName" value="{{ $userData->name }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label fw-bold" style="color:#44546d" >Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="text" name="phone" class="form-control shadow-none"
                                                    id="Phone" value="{{ $userData->phone }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label fw-bold" style="color:#44546d" >Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" name="email" class="form-control shadow-none"
                                                    id="Email" value="{{ $userData->email }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Address1"
                                                class="col-md-4 col-lg-3 col-form-label fw-bold"  style="color:#44546d">Address1</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address1" type="text" class="form-control shadow-none"
                                                    id="Address" placeholder="Please enter your address"
                                                    value="{{ $userData->address01 }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Address2"
                                                class="col-md-4 col-lg-3 col-form-label fw-bold"  style="color:#44546d">Address2</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address2" type="text" class="form-control shadow-none"
                                                    id="Address" placeholder="Please enter your address"
                                                    value="{{ $userData->address01 }}" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="pwd"
                                                class="col-md-4 col-lg-3 col-form-label fw-bold"  style="color:#44546d">Change Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="pwd" type="password" class="form-control shadow-none"
                                                    id="pwd" placeholder="Enter your password"
                                                    value="" required>
                                            </div>
                                        </div>
                                        {{-- <div class="row mb-3">
                                            <label for="conPwd"
                                                class="col-md-4 col-lg-3 col-form-label fw-bold">Change Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="conpwd" type="password" class="form-control"
                                                    id="conPwd" placeholder="Confirm your password"
                                                    value="" required>
                                            </div>
                                        </div> --}}

                                        <div class="text-center">
                                            <button type="submit" class="account__setting__btn" id="accDetails1">Save
                                                Changes</button>
                                        </div>
                                    </form>
                                </div>
                                <img src="assets/img/departments-4.jpg" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
            </div>

        </div><!-- End tab content item -->

    </div>

    </div>
    </section>


    <div class="modal fade" id="review" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Review & Ratings</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ url('bike?action=review') }}" method="POST" id="reviewForm">
                @csrf

                <input type="hidden" name="product_id" id="productId"> 
                <input type="hidden" name="booking_id" id="bookingId">
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Ratings</label>
                        {{-- <input type="hidden" class="form-control" id="" name="ratings"> --}}
                        <div class="text-end rotate-180" style="">

                            <input class="star star-1" id="star-1" type="radio" value="1" name="star"/>
                        
                            <label class="star star-1 rotate-180" for="star-1"></label>

                            <input class="star star-2 " id="star-2" type="radio" value="2" name="star"/>
                        
                            <label class="star star-2 rotate-180" for="star-2"></label>

                            <input class="star star-3 " id="star-3" type="radio" value="3" name="star"/>
                        
                            <label class="star star-3 rotate-180" for="star-3"></label>

                            <input class="star star-4" id="star-4" type="radio" value="4" name="star"/>
                        
                            <label class="star star-4 rotate-180" for="star-4"></label>

                            <input class="star star-5" id="star-5" type="radio" value="5" name="star"/>
                
                            <label class="star star-5 rotate-180" for="star-5"></label>
                        
                        
                            
                        </div>
                        
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Review</label>
                        <textarea class="form-control" id="" name="review" rows="2"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary review-submit">Submit</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>




    <!-- USERS BOOKING SECTION  ENDS -->


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Cencel Booking</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('bike?action=cencel-booking-by-user')}}" method="POST" id="cencelBooking">
                    @csrf
                    <input type="hidden" name="userBookingId" class="" id="bookingId" value="">
                   
                    <div class="form-group">
                        <label for="" class="form-label">Reason <span class="text-danger">*</span></label>
                        <input type="text" name="reason" class="form-control" placeholder="Enter your reason here..." required>
                    </div>
                <div class="float-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm" id="cencelBooking1">Apply</button>
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Cencel Reason</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
        
                    <div class="form-group">
                       <p id="vendorCencelReason"></p>
                    </div>
                <div class="float-end mt-3">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('#btnUploadImg').click(function() {
                $('#imgFile').click();
            });

            const width = 70;
            const height = 70;

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
                    'px; max-height: ' + height + 'px; border-radius:50%;"/>');
            });


            $('.modalClick').click(function(){
                let userBookingId = $(this).attr('data-id');
                $('#bookingId').val(userBookingId);
            });
             
            $('.viewR').click(function(){
                let reason = $(this).attr('data-rejectreason');
                $('#vendorCencelReason').html(reason);
            });
            
            $('#accDetails').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var error = $('.error');
                var submit = $("#accDetails1");
                // clear all error message
                error.text('');
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
                            if (data.data != null) {
                                $.each(data.data, function(id, error) {
                                    $('#' + id).text(error);
                                });
                            } else {
                                alert(data.message);
                            }
                        } else {
                            alert(data.message);
                            location.reload();

                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Save Changes');
                    }
                });
            });

            $('#cencelBooking').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#cencelBooking1");
                // clear all error message
              
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

                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Apply');
                    }
                });
            });


            $(document).on('click','.review-btn',function() {
                
                var bookingId = $(this).data('booking') ;
                var productId = $(this).data('product') ;


                $('#bookingId').val(bookingId) ;
                $('#productId').val(productId) ;
            })

            $('#reviewForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var error = $('.error');
                var submit = $(".review-submit");
                // clear all error message
                error.text('');
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

                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Submit');
                    }
                });
            });
        });
    </script>
@endsection
