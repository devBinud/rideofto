@extends('public.layout')
@section('title', 'Product-details')
@section('custom-css')

@endsection
@section('body')


    <style>
        .order__confirmation{
            margin-top: 90px;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            justify-content: center;
            background-color:#eee;
        }
        .order__confirmation__wrapper{
            border-radius:10px;
        }
        .accessories__price ul li {
            list-style: none
        }
        .order__locations{
            background-color: #242d4c;
            padding: 10px 20px;
            margin-top: 50px;
            color:#e4e4e4;
            border-radius:10px;
        }
        .order__locations__title{
            margin-bottom: 26px;
        }
        .order__locations__title h5{
          font-size:17px;
        }
        .order__locations__details{
            margin-top: 10px;
        }
        .order__locations__details ul li{
            list-style:none;
            margin-left: -30px;
            margin-bottom: 8px;
            color:#d5d5d5;
        }
    </style>

    <!-- OPDER CONFIRMATION SECTION STARTS -->

    <div id="order__confirmation" class="order__confirmation">
    <div class="order__confirmation__wrapper">
       <div class="container-fluid">
       <div class="row d-flex justify-content-center">

<div class="col-md-12">

    <div class="card" style=" box-shadow:none;border:3px dotted #ff5f00">


        <div class="text-center logo p-2 px-5">

            <img src="{{asset('assets/img/logo/logo.png')}}" width="80">
        </div>

        <div class="invoice p-5">
        <img  class="mb-2" src="{{asset('assets/img/icons/check.png')}}" alt=""
                    width="40">
            <h4 class="fw-bold">Order placed ! </h4>

            <span class="font-weight-bold d-block mt-4 text-start">Hello,
                <span style="color:#ff5f00;font-weight:600;">John Doe</span></span>
            <span class="text-start">You order has been successfully placed. Please
                wait for the confirmation.</span>
            <div class="order__locations text-start">
                <div class="order__locations__title">
                  <h5><i class="bi bi-send me-3" style="font-size:30px"></i>Your order will be sent to this address :</h5>
                </div>
                <div class="order__locations__details">
                    <ul>
                        <li><i class="me-3 bi bi-geo-alt"></i>Copenhegan, Denmark | 890051</li>
                        <li><i class="me-3 bi bi-telephone"></i>+45 123098012</li>
                        <li><i class="me-3 bi bi-envelope"></i>example@gmail.com</li>
                    </ul>
                </div>
            </div>
    
    </div>
</div>
</div>
       </div>

      
   </div>
    </div>
    <!-- ORDER CONFIRMATION SECTION ENDS -->

  

@endsection
@section('custom-js')

@endsection
