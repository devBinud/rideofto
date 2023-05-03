@extends('public.layout')
@section('title', 'Vendor Login')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/reg-log.css') }}">
  <style>
    .login-btn{
        width:100%;
        background: #f4664f;
        padding:13px 20px;
        font-size:17px;
        border-radius:8px;
        border:none;
        outline:none;
        color:#fff
    }
    .login-btn:hover{
        background: #d9472f;
        transition:0.3s ease
    }
    .login-form{
        background-color:#eee;
    }
    @media screen and (max-width:576px){
        .login-form{
        background-color:#fff!important;
    }
    .form-body{
        margin-top:52px;
        border:1px solid #eee;
        border-radius:4px
    }
    }
  </style>
@endsection
@section('body')


    <!-- LOGIN SECTION STARTS -->
    <section class="h-100 gradient-form login-form" style="margin-top:50px">
  <div class="container py-4 py-lg-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6 form-body">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <h4 class="mt-1 mb-4 pb-1 mb-lg-5">Vendor Login</h4>
                </div>

                <form action="{{ url('vendor/login') }}" method="POST" id="form" method="POST" autocomplete="off">
                @csrf
               
                <input type="hidden" name="" id="" value="">
                  <div class="form-outline mb-2 mb-lg-3">
                    <input type="phone" name="phone" maxlength="10" id="phone" class="form-control shadow-none" placeholder="Phone No "/>
                  </div>

                  <div class="form-outline mb-3 mb-lg-4">
                    <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Password" />
                  </div>

                  <div class="text-center pt-1 mb-3 mb-lg-3 pb-1">
                    <button class="login-btn">Login </button>
                  </div>
                  <div class="card-body bg-light-alt text-center">
                                <span class="text-muted d-none d-sm-inline-block">Rideofto ©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>
                                </span>
                            </div>
                </form>
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2" >
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">Rent, Ride and Explore</h4>
                <p class="small mb-0">“When the spirits are low, when the day appears dark, when work becomes monotonous, when hope hardly seems worth having, just mount a bicycle and go out for a spin down the road, without thought on anything but the ride you are taking.” — Arthur Conan Doyle, British author</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- LOGIN SECTION ENDS -->

@endsection
@section('custom-js')
 <script>
        $(document).ready(function() {

            // form submit
            $('#form').submit(function(e) {
                e.preventDefault();

                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: method,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function() {
                        $('#btnSubmit').text("Please wait ...").attr('disabled', true);
                    },
                    success: function(data) {
                        if (!data.success) {
                            alert(data.message);
                        } else {
                            window.location.replace("{{ url('vendor/dashboard') }}");
                            // alert(data.message);
                        }
                    },
                    complete: function() {
                        $('#btnSubmit').text("SIGN IN").attr('disabled', false);
                    }
                });
            });

        });
    </script>

@endsection
