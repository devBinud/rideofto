@extends('vendor.layout', [
    'pageTitle' => 'TERMS &
    CONDITIONS',
    'currentPage' => 'termsandservice',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active b1">Terms &
        Conditions</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="termsandc col-12" >

                    <div class=" " style="height: 70vh;overflow-y: auto;">

                        <h2>Terms and conditions : </h2>
                        <p>By joining the platform you agree to the following:</p>
                        <h5 class="card-title">You decide :
                        </h5>
                        <ul>
                            <li>When you want to join – You can start anytime.</li>
                            <li>When you want to leave -You can stop anytime, however please help the customers we sent to
                                you.
                            </li>
                            <li>Your prices – don’t make prices higher then in your own shop to avoid complaints.</li>
                            <li>About your policy with respect to deposits and insurance – We don’t take any deposit.</li>
                        </ul>
                        <h5 class="card-title">We help you to find customers :</h5>
                        <ul>
                            <li>No fixed costs.</li>
                            <li>Just 9,8 % commission on the total order value.
                            </li>
                            <li>Legally it is a contract between you and the rental customer.</li>
                            <li>We are an intermediairy</li>
                        </ul>
                        <h5 class="card-title">You have your own account</h5>
                        <ul>
                            <li>You can edit.</li>
                            <li>Your location information.</li>
                            <li>Your bikes and bike availability.</li>
                            <li>Your prices.
                            </li>
                            <li>Your opening hours and closing days.</li>
                            <li>You are responsible for your own information on our platform.</li>
                        </ul>
                        <h5 class="card-title">Payments
                        </h5>
                        <ul>
                            <li>Online payment model – no shows, no problem.
                            </li>
                            <li>Customer pays at reservation 9,8% of the order value to us. We keep that as our commission.
                            </li>
                            <li>If the customer cancel at least the 24 hours in advance, we refund the custome.</li>
                            <li>If the customer doesn’t cancel, we pay you, even if they don’t show up.
                            </li>
                            <li>The remaining 90,2% of the order value will be paid directly to you by the payment company.
                            </li>
                        </ul>
                        <h5 class="card-title">Legal</h5>
                        <ul>
                            <li>This agreement is subject to Danish law</li>
                        </ul>

                    </div>

                    <div class="text-center" style="">
                        <button type="button" class="btn btn-primary btn-lg my-4 px-5" id="btnNext"> Next <i
                            class="fas fa-arrow-alt-circle-right"></i></button>
                    </div>

                </div>
                <div class="agreement d-none col-12 ">
                    @if(empty($agreementData['currentAgreementFile']))

                        <div class="" style="height: 70vh;overflow-y: auto;">
                           <h4 class="text-center py-5 text-danger">No Agreement Data Found ! Please Contact Admin.</h4>

                        </div>
                        <div class="text-center" style="">
                            <button type="button" class="btn btn-primary btn-lg my-4 px-5" id="btnPrv"><i
                                class="fas fa-arrow-alt-circle-left"></i> Prv </button>
                            <button type="button" class="btn btn-success btn-lg my-4 px-5 btn-disabled" id="" disabled><i
                                class="far fa-check-circle"></i> Agree</button>
                        </div> 

                    @else

                    <form action="{{ url('vendor/terms-conditions-and-agreement') }}" method="POST" id="agreeForm">
                        @csrf
                        <div class="" style="height: 70vh;overflow-y: auto;">
                            <object data="{{ asset('assets/uploads/vendor-agreement').'/'.$agreementData['currentAgreementFile'] }}" type="application/pdf" width="100%" height="100%">
                                <p class="text-center text-secondary mt-5">Your browser doesn't support PDF!</p>
                                <p class="text-center"><a class="text-center btn btn-info" href="{{ asset('assets/uploads/vendor-agreement').'/'.$agreementData['currentAgreementFile'] }}">Download <i class="fa fa-download" aria-hidden="true"></i></a></p>
                            </object>

                        </div>
                        <div class="text-center" style="">
                            <button type="button" class="btn btn-primary btn-lg my-4 px-5" id="btnPrv"><i
                                class="fas fa-arrow-alt-circle-left"></i> Prv </button>
                            <button type="submit" class="btn btn-success btn-lg my-4 px-5" id="btnSubmit"><i
                                class="far fa-check-circle"></i> Agree</button>
                        </div> 
                    </form>


                    @endif
                    
                </div>
            </div>

        </div>
    </section>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click','#btnNext',function(){

                $('.termsandc').addClass('d-none') ;
                $('.agreement').removeClass('d-none') ;

                $('.page-title').html('Payment Aggrement') ;
                $('.b1').html('Payment Aggrement') ;

            })

            $(document).on('click','#btnPrv',function(){

                $('.agreement').addClass('d-none') ;
                $('.termsandc').removeClass('d-none') ;
                

                $('.page-title').html('TERMS & CONDITIONS') ;
                $('.b1').html('Terms & Conditions') ;

            })
            $('#agreeForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,

                    success: function(data) {

                        console.log(data);
                        if (!data.success) {
                            alert(data.message);
                        } else {
                            // alert(data.message);
                            window.location.replace("{{ url('vendor/dashboard') }}");

                        }
                    },

                });

            });
        });
    </script>
@endsection
