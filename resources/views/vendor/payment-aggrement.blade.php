@extends('vendor.layout', [
    'pageTitle' => 'Payment Aggrement',
    'currentPage' => 'Payment Aggrement',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Payment Aggrement</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-12" style="height: 70vh;overflow-y: auto;">
                    <object data="{{ asset('assets/uploads/vendor-agreement').'/'.$agreementData['currentAgreementFile'] }}" type="application/pdf" width="100%" height="100%">
                        <p class="text-center text-secondary mt-5">Your browser doesn't support PDF!</p>
                        <p class="text-center"><a class="text-center btn btn-info" href="{{ asset('assets/uploads/vendor-agreement').'/'.$agreementData['currentAgreementFile'] }}">Download <i class="fa fa-download" aria-hidden="true"></i></a></p>
                    </object>
                </div>
            </div>

        </div>
    </section>
@endsection


