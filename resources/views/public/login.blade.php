@extends('public.layout')
@section('title', 'Login')
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
                  <h4 class="mt-1 mb-4 pb-1 mb-lg-5">Login to Rideofto</h4>
                </div>

                <form  action="{{ url('login') }}" method="POST" id="loginForm">
                @csrf
               
                <input type="hidden" name="goto" id="goto" value="{{$goto}}">
                  <div class="form-outline mb-2 mb-lg-3">
                    <input type="phone" name="phone" maxlength="10" id="phone" class="form-control shadow-none" placeholder="Phone No "/>
                  </div>

                  <div class="form-outline mb-3 mb-lg-4">
                    <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Password" />
                  </div>

                  <div class="text-center pt-1 mb-3 mb-lg-5 pb-1">
                    <button class="login-btn">Login </button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-3 pb-lg-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <a type="button" href="{{ url('/register') }}" class="btn btn-outline-danger">Register Now</a>
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
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                // alert('hi');

                var goto = $('#goto').val();
                // alert(goto);
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (!data.success) {
                            alert(data.message);
                        } else {
                            // location.reload();

                            if (goto == '') {
                                window.location.replace("{{ url('bike/bike-store') }}");
                            } else {
                                window.location.replace(goto);
                            }

                        }
                    }
                });
            });
        });
</script>
@endsection
