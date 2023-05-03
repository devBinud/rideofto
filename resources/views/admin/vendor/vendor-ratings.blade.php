@extends('admin.layout', [
    'pageTitle' => 'All Vendor List',
    'currentPage' => 'vendor',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item">Vendor List</li>
    <li class="breadcrumb-item active">Vendor Details</li>
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
                    <a href="{{ url('admin/vendor?action=vendor-item-lists&id='.$id) }}" type="button" class="btn btn-sm btn-outline-primary">Item Lists</a>
                    <a href="{{ url('admin/vendor?action=vendor-orders&id='.$id) }}" type="button" class="btn btn-sm btn-outline-primary">Orders</a>
                    <button type="button" class="btn btn-sm btn-primary">Review and Ratings</button>
                </div>

            </div>
            <div class="col-md-12 mt-2" style="border:1px solid #dee4e7;border-radius:10px;min-height:50vh">

                @if (count($approvedData) > 0)
                    <div class="table mt-3">
                        <table class="table table-bordered text-center table-responsive">
                            <thead class="text-uppercase bg-dark">
                                <tr>

                                    <th class="text-white fw-bold">#</th>
                                    <th class="text-white fw-bold">Booking Id</th>
                                    <th class="text-white fw-bold">Product</th>
                                    <th class="text-white fw-bold">Name</th>
                                    <th class="text-white fw-bold">Ordered At</th>
                                    <th class="text-white fw-bold">Ratings</th>
                                    <th class="text-white fw-bold">Review</th>
                                    <th class="text-white fw-bold">Date</th>

                                
                                    <th class="text-white fw-bold">Action</th>
                                

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvedData as $item)
                                    <tr>
                                        <td class="px-3">{{ ++$sn }}</td>
                                        <td class="">{{ 'RIDEOF_' . $item->id }}</td>
                                        <td>
                                            <img src="{{ asset('assets/uploads/product-image').'/'.$item->product_thumbnail }}" width="70px" alt=""> <br>
                                            {{ $item->product_name }}
                                        </td>
                                        <td class="">
                                            <a type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                data-userid="{{ $item->userId }}"
                                                class="btn btn-sm text-primary fw-bold viewUser"
                                                href="">{{ $item->username }}</a>
                                        </td>

                                        <td class="">{{ date('d M,Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @for($i=1 ; $i<6 ;$i++)

                                            <i class="far fa-star @if($i <= $item->ratings) text-warning @endif"></i>

                                            @endfor
                                        </td>
                                        <td>{{ $item->review ?? 'n/a' }}</td>

                                        <td class="">{{ date('d M,Y', strtotime($item->review_created_at)) }}</td>
                                        

        
                                        
                                        
                                        <td> <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                data-bookingid="{{ $item->id }}"
                                                class="btn btn-primary btn-sm px-2 viewAll">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div id="paginationBox" class="my-5"></div>
                @else
                    <h4 class="text-center text-danger mt-4 p-4">No data found!</h4>
                @endif
                
            </div>
           
        </div>


    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="appendHere" style="min-height: 300px"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    

@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
         $(document).ready(function() {

            $("#paginationBox").pxpaginate({
                currentpage: {{ $approvedData->currentPage() }},
                totalPageCount: {{ ceil($approvedData->total() / $approvedData->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/vendor/action=vendor-review-ratings&id=$id&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });

            $(document).on('click', '.viewUser', function(e) {
                e.preventDefault();
                $('#staticBackdropLabel').html('User Details');
                let userId = $(this).attr('data-userid');
                $('#appendHere').html('<h4 class="text-center p-3">Please wait...</h4>');
                let url = "{{ url('admin/user?action=get-user-details') }}";
                $.get(url + "&userId=" + userId + "&type=" + "viewUser", function(data) {
                    $('#appendHere').html(data.html);
                });
            });

            $(document).on('click', '.viewAll', function(e) {
                e.preventDefault();
                $('#staticBackdropLabel').html('Booking Details');
                let bookingId = $(this).attr('data-bookingid');
                $('#appendHere').html('<h4 class="text-center p-3">Please wait...</h4>');
                let url = "{{ url('admin/user?action=get-user-details') }}";
                $.get(url + "&bookingId=" + bookingId + "&type=" + "viewBooking" + "&status=" + 'approved', function(data) {
                    $('#appendHere').html(data.html);
                });
            });

         })
            
        
    </script>
@endsection
