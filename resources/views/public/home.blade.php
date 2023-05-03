@extends('public.layout')
@section('title', 'Home')
@section('custom-css')
<style>
    .text-orange{
        color: #e87765;
        font-size: 18px;
    }
    .get-started-btn{
        background:#f4664f;
        padding:10px 20px;
        color:#fff;
        border-radius:8px;
        border:2px solid #f4664f;
    }
    .get-started-btn:hover{
        border:2px solid #f4664f;
        background:transparent;
        color:#fff;
        transition:0.3s ease;
    }
    .view-all-product{
        padding:10px 20px;
        margin:20px 0;
        background:#f4664f;
        color:#fff;
        border:none;
        outline:none;
        border-radius:7px;
    }
  
    .view-all-product:hover{
       background:#d9472f;
       transition:0.3s ease
    }
    .hire-bike-btn{
        margin-top:-30px;
        background:transparent;
        border:1px solid #f4664f;
        text-align:center;
        padding:8px 16px;
        border-radius:7px;
        color:#f4664f;
        outline:none;
        font-size:20px;
    }
    .hire-bike-btn:hover{
        background:#d9472f;
        border:1px solid #f4664f;
        color:#fff;
        transition:0.3s ease
    }
    .hire-us-wrapper{
        margin-top:30px;
    }
    .hire-us-wrapper ul li{
        list-style: none;
        margin-left:-20px
    }
    
    .hire-us-btn{
        background:#f4664f;
        padding:7px 16px;
        border:1px solid #f4664f;
        color:#fff;
        border-radius:5px;
    }
    .hire-us-btn:hover{
        background:transparent;
        border:1px solid #f4664f;
        color:#f4664f;
    }
    .why-us-wrapper h6, .hire-us-wrapper h6{
        color:#f4664f;
        font-size:16px;
    }
    .why-us-wrapper h4, .hire-us-wrapper h4{
        font-weight:600
    }
    @media screen and (max-width:576px){
        .text-orange{
        font-size: 14px;
        }
        .hero-main-header{
        font-size:18px;
        }
        .lead{
            font-size:15px;
        }
        .get-started-btn{
            font-size: 12px;
            border: 1px solid #f4664f;
            padding: 6px 10px;
            border-radius: 6px;
        }
        .form-header{
            font-size:16px!important;
        }
       .why-us-wrapper h6, .hire-us-wrapper h6{
          font-size:13px;
        }
        .hire-bike-btn{
          padding: 6px 10px;
          font-size:13px;
        }
        .view-all-product{
            padding: 10px 16px;
            margin: 16px 0;
            font-size: 13px;
        }
        .hire-us-btn{
           font-size:13px;
        }
        .hire-us-row{
            margin-top:-40px!important;
        }
    }
</style>
@endsection
@section('body')

<!-- Hero Section start -->
<section class="pt-5 pb-5 pb-0 homepage-hero-module" style="background-size: cover; min-height: 73vh; background-image: url(&quot;https://images.unsplash.com/photo-1623216216626-f8bfd191552d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80);" >
        <div class="bg-overlay position-absolute"></div>
        <div class="container position-relative zindex-1 pt-3 pb-3">
          <div class="row text-align-left align-content-center justify-content-between " style="margin-top:100px;">
            <div class="col-12 col-md-7 pr-md-5 text-left align-self-center text-align-left "> 
            <p class="lead text- text-orange">Keep Healthy, Ride Everyday</p>
              <h1 class="mb-4 text-white font-weight-bold hero-main-header"><strong>Ride a bicycle and keep yourself healthy and fit</strong></h1>
             
              <p class="lead text-white">Try these cool bikes because they don’t need fuel to get started ,We just do not deliver bikes , we deliver passion for your adventurous life . </p>
              <p class="text-h3 mt-4">
                <a href="" class="get-started-btn">Get Started <i class="fa fa-arrow-right ms-1"></i></a>
              </p>
            </div>
            <div class="col-12 col-md-5 mt-3 mt-lg-0">
              <div class="card shadow-lg text-white text-left h-100">
                <div class="card-body px-4 py-4 py-lg-5" style="background: #f4664f;border-radius: 7px;">
                  <h3 class="pb-0 pb-lg-3 font-weight-bold text-center form-header" style="font-size:24px">Enjoy the freedom on these two wheels</h3>
                  <form action="#" method="post" class="registration-form">
                  <div class="col-md-12 mt-5">
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control shadow-none" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput" style="color:#9a9191">Location</label>
                  </div>
            <div class="form-floating mt-3">
                  <select class="form-select shadow-none" id="floatingSelect" aria-label="Floating label select example" >
                        <option selected>Please select</option>
                        <option value="1">Road Bikes</option>
                        <option value="2">Mountain Bikes</option>
                        <option value="3">City Bikes</option>
                        <option value="3">Mountain Bikes</option>
                        <option value="3">Others</option>
                        </select>
                    <label for="floatingSelect" style="color: orangered;">Bicycle Type</label>
             </div>
             <div class="row mt-2">
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                    <label for="" class="mb-1">Pickup Date <span class="text-white"> *</span></label>
                    <input type="date">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                    <label for="" class="mb-1">Return Date <span class="text-white"> *</span></label>
                    <input type="date">
                    </div>
                </div>
             </div>
		   </div>
                    <a href="{{ url('bike/bike-store') }}" class="btn btn-dark d-block py-2 py-lg-3 mt-3">Search your bicycle now</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
</section>
<!-- Hero Section end -->

<!-- Top product section start -->
<section style="background-color: #eee;">
  <div class="container py-0">
            <div class="section-header">
                <h2>Best Bikes</h2>
                <p>Top <span>Products</span></p>
            </div>
    <div class="row">
        @if (count($productData) > 0)
        @foreach ($productData as $data)
        <div class="col-md-8 col-lg-6 col-xl-3 col-6 mt-3 mt-lg-0">
            <div class="card" style="border-radius: 7px;width:100%;height:100%">
            <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light"
                data-mdb-ripple-color="light" style="height: 57%; width: 95%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;">
                <img src="{{ asset('assets/uploads/product-image/' . $data->product_thumbnail) }}"
                style="border-top-left-radius: 15px; border-top-right-radius: 15px;" class="img-fluid"
                alt="mountain-bike" />
                <a href="#!">
                <div class="mask"></div>
                </a>
            </div>
            <div class="card-body pb-0">
                <div class="d-flex justify-content-between">
                <div>
                    <h6 class="fw-bold">{{ $data->product_name }}</h6>
                    <p class="text-secondary" style="margin-top:-4px">15 Miles away ...</p>
                    <small class="text-danger">
                        @if(!empty($data->discount))

                            @if($data->discount_type == 'flat')

                            Flat {{ $data->discount }} DKK OFF

                            @elseif($data->discount_type == 'percentage')

                            {{ $data->discount }} % OFF

                            @endif

                            @else
                            &nbsp;
                            @endif
                    </small>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-1">
                <a type="button" href="{{ url('product-details', ['slug' => $data->product_slug]) }}" class="hire-bike-btn w-100">Hire Your Bike</a>
                </div>
            
            </div>
            </div>
     </div>
  
        @endforeach
            @else
            <div class="col-12 mt-3">
            <h5 class="py-2 text-center text-white" style="background-color:#ff5f00">No Data Found</h5>
            </div>
        @endif
    </div>
   <div class="col-12 text-center">
    <a type="button" href="{{ url('bike?action=bike-store') }}" class="view-all-product text-white">View All Product <i class="fa fa-arrow-right ms-1"></i> </a>
   </div>
  </div>
</section>
<!-- Top product section ends -->

<!-- Trending vendor section start -->
<section id="featured-services" class="featured-services" style="background:#F5FBFF">
    <div class="container">
    <div class="section-header">
              <h2>Vendors</h2>
              <p>Trending <span>Vendors</span></p>
          </div>
      <div class="row gy-4">
      @foreach ($vendor as $vData)
        <div class="col-xl-3 col-md-3 col-6 d-flex" data-aos="zoom-out">
          <div class="service-item position-relative">
            <div class="icon">
             <img src="{{ asset('assets/img/section-images/johnbike.png') }}" alt="vendor-img"> 
            </div>
            <div class="service-item-content bgs-secondary">
              <h4><a href="{{ url('bike?action=bike-store') }}" class="stretched-link">{{ $vData->store_name }}</a></h4>
              <p class="text-secondary" style="margin-top:-10px">Copenhagen , Denmark</p>
            </div>
          </div>
        </div><!-- End Vendor Item -->
        
      @endforeach 
      </div>
    </div>
</section>
<!-- Trending Vendor Section ends -->

 <!-- Why us section start -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row g-4 g-lg-5" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-4">
            <div class="about-img">
              <img src="assets/img/why-us.jpg" class="img-fluid" alt="" style="border:1px solid #ddd">
            </div>
          </div>

         <div class="col-lg-8 d-flex align-items-center justify-content-center flex-column text-align-start">
            <div class="main-wrapper">
            <div class="why-us-wrapper">
                <h6>WHY CHOOSE US</h6>
                <h4>Want to Rent <span style="color:#f4664f;">a Bike </span> ?</h4>
                
                <div class="why-us-inner-wrapper">
                    <h5>Easy Booking Process</h5>
                    <p class="text-secondary">
                    We have optimized the booking process so that our clients can experience the easiest and the safest service!
                    </p>
                    <h5>Convenient Pick-Up & Return Process</h5>
                    <p class="text-secondary">
                    By following a few company's policy rules, you get to pick up and return the vehicle in a simple and convenient way.
                    </p>
                 </div>
            </div>
            <div class="hire-us-wrapper">
              <h6>HOW TO FIND US</h6>
              <h4>Bike rental – <span style="color:#f4664f;">Search, Compare & rent</span> ?</h4>
              
              <ul>
                <li><i class="bi bi-check-circle me-3" style="color:#f4664f;"></i>Price Match Guarantee</li>
                <li><i class="bi bi-check-circle me-3" style="color:#f4664f;"></i>Free cancellations on most bookings</li>
              </ul>
              <button class="hire-us-btn">Hire Now</button>
           </div>
            </div>
         </div>

        </div>

      </div>
    </section>
 <!-- Why us section ends -->

 <!-- How to hire us section starts -->
   <div id="hire-us" class="hire-us py-3" style="background:#eee;">
        <div class="container">
                    <div class="section-header">
                        <h2>HOW TO HIRE US</h2>
                        <p>Make 3 Simple steps to  <span>Hire a Bike</span></p>
                    </div>
                    <div class="row hire-us-row">
                        <div class="col-md-4 Services-tab  item">
                            <div class="folded-corner service_tab_1">
                                <div class="text">
                                    <i class="bi bi-bicycle fa-5x fa-icon-image"></i>
                                        <p class="item-title"> 
                                                <h3> Choose Your Bike</h3>
                                            </p><!-- /.item-title -->
                                    <p>
                                    Select the Bike you want to hire
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 Services-tab item">
                            <div class="folded-corner service_tab_1">
                                <div class="text">
                                    <i class="fa fa-lightbulb fa-5x fa-icon-image" ></i>
                                        <p class="item-title">
                                            <h3>Make a Booking</h3>
                                        </p><!-- /.item-title -->
                                        <p>
                                        Fill in the form with your booking details.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 Services-tab item">
                            <div class="folded-corner service_tab_1">
                                <div class="text">
                                    <i class="bi bi-geo-alt fa-5x fa-icon-image"></i>
                                        <p class="item-title">
                                            <h3>Enjoy the Ride</h3>
                                        </p>
                                    <p>
                                    Be flexible with our multiple hiring locations
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
   </div>
 <!-- How to hire us section ends -->

 <!-- Contact Section Starts -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Contact</h2>
                <p>Need Help? <span>Contact Us</span></p>
            </div>

            <div class="row gy-4">
                <div class="col-md-4">
                    <div class="info-item">
                        <div class="info_item_box">
                            <i class="icon bi bi-geo-alt flex-shrink-0"></i>
                            <h3>Our Address</h3>
                        </div>
                        <div>
                            <p>Copenhegan, Denmark, Pin 001010</p>
                        </div>
                    </div>
                </div><!-- End contact card Item -->

                <div class="col-md-4">
                    <div class="info-item">
                        <div class="info_item_box">
                            <i class="icon bi bi-envelope flex-shrink-0"></i>
                            <h3>Email Us</h3>
                        </div>
                        <div>
                            <p>contact@rideofto.com</p>
                        </div>
                    </div>
                </div><!-- End contact card Item -->

                <div class="col-md-4">
                    <div class="info-item">
                        <div class="info_item_box">
                            <i class="icon bi bi-telephone flex-shrink-0"></i>
                            <h3>Call Us</h3>
                        </div>
                        <div>
                            <p>+91 12345 67890</p>
                        </div>
                    </div>
                </div><!-- End contact card Item -->
            </div>

            <div class="row">
                <div class="col-md-5 mt-5">
                    <iframe style="border:0; width: 100%; height: 280px;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2272024.8258853815!2d9.300494175024296!3d56.21285968339479!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x464b27b6ee945ffb%3A0x528743d0c3e092cd!2sDenmark!5e0!3m2!1sen!2sin!4v1675662356842!5m2!1sen!2sin"
                        frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="col-md-7">
                    <form action="forms/contact.php" method="" role="form" class="php-email-form p-3 p-md-4">
                        <div class="row">
                            <div class="col-lg-6 form-group">
                            <div class="form-floating mb-3">
                    <input type="text" class="form-control shadow-none" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput" style="color:#9a9191">Name</label>
                  </div>
                            </div>
                            <div class="col-lg-6 form-group">
                            <div class="form-floating mb-3">
                    <input type="email" class="form-control shadow-none" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput" style="color:#9a9191">Email</label>
                  </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12 form-group">
                        <div class="form-floating mb-3">
                    <input type="text" class="form-control shadow-none" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput" style="color:#9a9191">Subject</label>
                  </div>
                            </div>
                        </div>
                        <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2" style="color: #9a9191;font-size: 15px;">Message</label>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="button" class="form-button">Send Message</button>
                        </div>
                    </form>
                </div>

            </div>
            <!--End Contact Form -->
        </div>
    </section>
<!-- End Contact Section -->

@endsection
@section('custom-js')

@endsection
