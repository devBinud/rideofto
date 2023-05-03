@extends('public.layout')
@section('title', 'Product-details')
@section('custom-css')

@endsection
@section('body')


    <style> 
    .order__summary{
        width: 100%;
        margin-top: 170px;
        height: 100vh;
        display: flex;
        align-items: center;
        text-align: start;
        justify-content: center;
        padding: 40px 0;
    }
    .order__summary__wrapper{
        width: 50%;
        height: 100vh;
        display: flex;
        align-items: center;
        text-align: start;
        justify-content: center;
    }     
        .accessories__price ul li {
            list-style: none
        }
        
    
    </style>

   <!-- ORDER SUMMARY SECTION STARTS -->
   <section id="order__summary" class="order__summary">
    <div class="order__summary__wrapper">
        <div class="container-fluid">
        <div class="container">
        <div class="m-5"></div>

        <div class="row d-flex justify-content-center">

            <div class="col-md-12">

                <div class="card" style="box-shadow:none;border:3px dotted #f6a475!important;">

                    <div class="invoice p-5">

                        <span class="fw-bold text-center d-block" style="font-size:22px;margin-bottom:40px;">ORDER SUMMARY</span>

                        <div class="payment border-top mt-3 mb-3
                    border-bottom table-responsive">

                            <table class="table table-borderless">

                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="py-2">

                                                <span
                                                    class="d-block
                                            text-muted">Order
                                                    Date</span>
                                                <span>12 Jan,2023</span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="py-2">

                                                <span
                                                    class="d-block
                                            text-muted">Order
                                                    No</span>
                                                <span>ROF00023</span>

                                            </div>
                                        </td>

                                        <td>
                                            <div class="py-2">

                                                <span
                                                    class="d-block
                                            text-muted">Payment</span>
                                                <span><img src="https://img.icons8.com/color/48/000000/mastercard.png"
                                                        width="60" /></span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="py-2">

                                                <span
                                                    class="d-block
                                            text-muted">Shiping
                                                    Address</span>
                                                <span>414 Advert Avenue,
                                                Denamrk</span>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>


                        <div class="product border-bottom table-responsive">
                            <table class="table table-borderless">

                                <tbody>
                                    <tr style="border-bottom: 1px solid #ddd;">
                                        <td width="20%">

                                            <img src="assets/img/product-images/p1.jpg" width="90">

                                        </td>

                                        <td width="60%">
                                            <span class="fw-bold">CR001
                                                Street Bicycle</span>
                                            <div class="product-qty">
                                                <span class="d-block">Quantity : 1</span>
                                                <span>Color : Dark</span>
                                            </div>
                                        </td>
                                        <td width="20%">
                                            <div class="text-right">
                                                <span class="fw-bold">DKK
                                                    67.50</span>
                                            </div>
                                        </td>
                                    </tr>

    
                                    <tr>
                                        <td width="20%">

                                            <span style="font-weight:600">
                                                ACCESSORIES</span>


                                        </td>

                                        <td width="60%">
                                            <div class="accessoroies__list">
                                                <ul>
                                                    <li>Helmet</li>
                                                    <li>Pedal</li>
                                                    <li>Riding mask</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td width="20%">
                                            <div class="accessories__price">
                                                <ul>
                                                    <li>DKK 4.3</li>
                                                    <li>DKK 2.2</li>
                                                    <li>DKK 3.5</li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>



                        </div>



                        <div class="row d-flex justify-content-between">
                        <div class="col-md-5">

<table class="table table-borderless">
    <tbody>
<div class="insurance__upload__box mt-5">
<label class="form-label fw-bold" for="customFile">Upload Insurance</label>
<input type="file" class="form-control" id="customFile" />
</div>

    </tbody>

</table>

</div>
                            <div class="col-md-5">

                                <table class="table table-borderless">
                                    <tbody class="totals">

                                        <tr>
                                            <td>
                                                <div class="text-left">
                                                    <span class="text-muted">Subtotal</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span>DKK 168.50</span>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <div class="text-left">
                                                    <span class="text-muted">Shipping
                                                        Fee</span>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span>DKK 22</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="text-left">
                                                    <span class="text-muted">Discount</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span class="text-success">DKK
                                                        168.50</span>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr class="border-top
                                    border-bottom">
                                            <td>
                                                <div class="text-left">
                                                    <span class="fw-bold">Subtotal</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span class="fw-bold">DKK
                                                        238.50</span>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>



                        </div>

                    </div>


                </div>

            </div>

        </div>
<div class="col-12 text-center">

<button class="continue__button">CONTINUE <i class="bi bi-arrow-right fw-bold"></i></button>

</div>
    </div>

        </div>
    </div>
   </section>
   <!-- ORDER SUMMARY SECTION ENDS -->


@endsection
@section('custom-js')
<script>
    $(document).ready(function(){
        $('.continue__button').click(function(){
            window.location.replace("{!! url('order-confirmation') !!}");
        });
});
</script>

@endsection
