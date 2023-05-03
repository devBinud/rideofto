@extends('admin.layout', [
    'pageTitle' => 'TERMS &
        CONDITIONS',
    'currentPage' => 'TERMS CONDITIONS',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Terms &
        Conditions</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="termsandc">
                    <form action="{{ url('vendor/terms-conditions') }}" method="POST" id="agreeForm">
                        @csrf
                        <div style="">
                            <h2>Terms and conditions : </h2>
                            <p>By joining the platform you agree to the following:</p>
                            <h5 class="card-title">You decide :
                            </h5>
                            <ul>
                                <li>When you want to join – You can start anytime</li>
                                <li>When you want to leave -You can stop anytime, however please help the customers we sent to
                                    you
                                </li>
                                <li>Your prices – don’t make prices higher then in your own shop to avoid complaints</li>
                                <li>About your policy with respect to deposits and insurance – We don’t take any deposit</li>
                            </ul>
                            <h5 class="card-title">We help you to find customers :</h5>
                            <ul>
                                <li>No fixed costs</li>
                                <li>Just 9,8 % commission on the total order value
                                </li>
                                <li>Legally it is a contract between you and the rental customer</li>
                                <li>We are an intermediairy</li>
                            </ul>
                            <h5 class="card-title">You have your own account</h5>
                            <ul>
                                <li>You can edit</li>
                                <li>Your location information</li>
                                <li>Your bikes and bike availability</li>
                                <li>Your prices
                                </li>
                                <li>Your opening hours and closing days</li>
                                <li>You are responsible for your own information on our platform</li>
                            </ul>
                            <h5 class="card-title">Payments
                            </h5>
                            <ul>
                                <li>Online payment model – no shows, no problem
                                </li>
                                <li>Customer pays at reservation 9,8% of the order value to us. We keep that as our commission
                                </li>
                                <li>If the customer cancel at least the 24 hours in advance, we refund the custome</li>
                                <li>If the customer doesn’t cancel, we pay you, even if they don’t show up
                                </li>
                                <li>The remaining 90,2% of the order value will be paid directly to you by the payment company
                                </li>
                            </ul>
                            <h5 class="card-title">Legal</h5>
                            <ul>
                                <li>This agreement is subject to Danish law</li>
                            </ul>

                        </div>

                       
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
   
@endsection
