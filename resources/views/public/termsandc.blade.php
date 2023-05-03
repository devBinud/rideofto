@extends('public.layout')
@section('title', 'Product-details')
@section('custom-css')

@endsection
@section('body')

    <style>
        .termsandc h6 {
            text-transform: uppercase;
            font-weight: 600
        }
    </style>

    <!-- TERMS AND CONDITION SECTION STARTS -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="search__bikes">
                        <p>TERMS AND CONDITIONS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="termsandc">
                    <h2>Terms and conditions bike hire shops : </h2>
                    <p>By joining the platform you agree to the following:</p>
                    <h6>You decide :
                    </h6>
                    <ul>
                        <li>When you want to join – You can start anytime</li>
                        <li>When you want to leave -You can stop anytime, however please help the customers we sent to you
                        </li>
                        <li>Your prices – don’t make prices higher then in your own shop to avoid complaints</li>
                        <li>About your policy with respect to deposits and insurance – We don’t take any deposit</li>
                    </ul>
                    <h6>We help you to find customers :</h6>
                    <ul>
                        <li>No fixed costs</li>
                        <li>Just 9,8 % commission on the total order value
                        </li>
                        <li>Legally it is a contract between you and the rental customer</li>
                        <li>We are an intermediairy</li>
                    </ul>
                    <h6>You have your own account</h6>
                    <ul>
                        <li>You can edit</li>
                        <li>Your location information</li>
                        <li>Your bikes and bike availability</li>
                        <li>Your prices
                        </li>
                        <li>Your opening hours and closing days</li>
                        <li>You are responsible for your own information on our platform</li>
                    </ul>
                    <h6>Payments
                    </h6>
                    <ul>
                        <li>Online payment model – no shows, no problem
                        </li>
                        <li>Customer pays at reservation 9,8% of the order value to us. We keep that as our commission</li>
                        <li>If the customer cancel at least the 24 hours in advance, we refund the custome</li>
                        <li>If the customer doesn’t cancel, we pay you, even if they don’t show up
                        </li>
                        <li>The remaining 90,2% of the order value will be paid directly to you by the payment company</li>
                    </ul>
                    <h6>Legal</h6>
                    <ul>
                        <li>This agreement is subject to Danish law</li>
                    </ul>

                </div>
            </div>

        </div>
    </section>
    <!-- Shop Section End -->

    <!-- TERMS AND CONDITION SECTION ENDS -->



@endsection
@section('custom-js')

@endsection
