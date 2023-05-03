@extends('admin.layout', [
    'pageTitle' => 'All Vendor List',
    'currentPage' => 'vendor',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item">Vendor List</li>
    <li class="breadcrumb-item active">Item Lists</li>
@endsection

@section('custom-css')
    <style>
        .count {
            font-weight: bold !important;
        }

        .counter-card:hover {
            scale: 1.1 !important;
            cursor: pointer;
        }
    </style>
@endsection

@section('body')
    
    <div class="card">
        <div class="card-body row">
            <div class=" col-md-12 vendor__profile__details text-center">
                <img src="{{ asset('assets/img/section-images/johnbike.png') }}" alt="profile-img" height="70vh">
                <h4 class="fw-bold" style="color:#ff5f00;">{{ $data->store_name }}</h4>
                <h5 class="text-dark"><i class="fa fa-map-pin me-2"  style="color:#ff5f00;"></i>{{ $data->region }}, {{ $data->city_town }}</h5>

                <div class=" text-center">
                    <a href="{{ url('admin/vendor?action=vendor-details&id=').$id }}" type="button" class="btn btn-sm btn-outline-primary">Vendor Details</a>
                    <a href="{{ url('admin/vendor?action=vendor-item-lists&id=').$id }}" type="button" class="btn btn-sm btn-outline-primary">Item Lists</a>
                    <button type="button" class="btn btn-sm btn-primary">Orders</button>
                    <a href="{{ url('admin/vendor?action=vendor-review-ratings&id=').$id }}" type="button" class="btn btn-sm btn-outline-primary">Review and Ratings</a>
                </div>

            </div>
            <div class="col-md-12 mt-3" style="border:1px solid #dee4e7;border-radius:10px">
                <div class="row">

                    <div class="col-12 text-center py-3">
                        <a href="{!! url('admin/vendor?action=vendor-orders&filter=All&id=').$id !!}" type="button" class="btn btn-sm @if($filter=='All') btn-primary @else btn-outline-primary @endif">All</a>
                        <a href="{!! url('admin/vendor?action=vendor-orders&filter=Ongoing&id=').$id !!}" type="button" class="btn btn-sm @if($filter=='Ongoing') btn-primary @else btn-outline-primary @endif">Ongoing</a>
                        <a href="{!! url('admin/vendor?action=vendor-orders&filter=Completed&id=').$id !!}" type="button" class="btn btn-sm @if($filter=='Completed') btn-primary @else btn-outline-primary @endif">Completed</a>
                        <a href="{!! url('admin/vendor?action=vendor-orders&filter=Failed&id=').$id !!}" type="button" class="btn btn-sm @if($filter=='Failed') btn-primary @else btn-outline-primary @endif">Failed</a>
                    </div>



                    @if(count($orderData) > 0)

                        @foreach ($orderData as $od)

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <table class="table table-sm table-borderless mb-0 text-center align-top" style="font-size:0.8rem">
                                        <tr class="text-uppercase">
                                            <th class="text-primary" width="15%">Status</th>
                                            <th class="text-primary" width="20%">Order Id</th>
                                            <th class="text-primary" width="15%">Plan</th>
                                            <th class="text-primary" width="15%">Total</th>
                                            <th class="text-primary" width="15%">Addn.</th>
                                            <th class="text-primary" width="20%">Placed</th>
                                        </tr>
                                        <tr>
                                            <td><h6 class = "m-0 text-dark fw-bold" > <span class="badge bg-success">{{ $od->status }}</span></h6></td>
                                            <td><h6 class = "m-0 text-dark fw-bold" > RIDEOF_{{ $od->booking_id }}</h6></td>
                                            <td><h6 class = "m-0 text-dark fw-bold" > {{ $od->pricing_plan_unit }}</h6></td>
                                            <td><h6 class = "m-0 text-dark fw-bold" > {{ $od->final_booking_price.' '.$od->currency }}</h6></td>
                                            <td><h6 class = "m-0 text-dark fw-bold" > {{ $od->addn_charge ?? '0'.' '.$od->currency }} </h6></td>
                                            <td><h6 class = "m-0 text-dark fw-bold" > {{ date('d/m/Y , H:i A' ,strtotime($od->created_at)) }}</h6></td>
                                        </tr>
                                    </table>
                                    
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless ">
                                        <tr>
                                            <td width="15%"><img src="{{ asset('assets/uploads/product-image').'/'.$od->product_thumbnail }}" width="100px" alt=""></td>
                                            <td width="27%" class="align-top">
                                                <h6>Product : {{ $od->product_name }}</h6>
                                                <h6>User : {{ $od->name }}</h6>
                                                <h6>Phone : {{ $od->phone }}</h6>
                                                <h6>Email : {{ $od->email }}</h6>
                                            </td>
                                            <td width="27%" class="align-top">
                                                <h6>Booking From : {{ date('d/m/Y' ,strtotime($od->pickup_date)).' '.date(' H:i A' ,strtotime($od->pickup_time)) }}</h6>
                                                <h6>Booking To  : {{ date('d/m/Y' ,strtotime($od->return_date)).' '.date('H:i A' ,strtotime($od->return_time)) }}</h6>
                                                <h6>Return Date : {{ date('d/m/Y , H:i A' ,strtotime($od->returned_at)) }}</h6>
                                                <h6>Payment : CASH</h6>
                                            </td>
                                            <td width="28%" class="align-top">
                                                @if(!empty($od->acc_prod))
                                                    <ol>
                                                        @foreach(explode(',',$od->acc_prod) as $key=>$acc)

                                                            <li>{{ explode(',',$od->acc_prod)[$key] }} ( {{ explode(',',$od->acc_price)[$key].' '.explode(',',$od->acc_curency)[$key] }} )</li>

                                                        @endforeach
                        
                                                    </ol>

                                                @else
                                                <span class="text-danger">No Accessories Added</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                            
                        @endforeach



                    @else 

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="py-2 text-danger">No Data Found</h4>
                                    
                                </div>
                            </div>
                        </div>



                    @endif
                    

                </div>
                
               
            </div>
            
           
        </div>


    </div>

    

@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        
    </script>
@endsection
