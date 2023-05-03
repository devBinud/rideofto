@extends('admin.layout', [
    'pageTitle' => 'Review & Ratings',
    'currentPage' => 'reviewratings',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Review & Ratings</li>
@endsection

@section('custom-css')
@endsection

@section('body')

{{-- {{ dd($approvedData) }} --}}

    <div class="card">
        <div class="card-body" style="min-height:50vh">
            @if (count($approvedData) > 0)
                <div class="table mt-3">
                    <table class="table table-bordered text-center table-responsive">
                        <thead class="text-uppercase bg-dark">
                            <tr>

                                <th class="text-white fw-bold">#</th>
                                <th class="text-white fw-bold">Booking Id</th>
                                <th class="text-white fw-bold">Product</th>
                                <th class="text-white fw-bold">Store</th>
                                <th class="text-white fw-bold">User</th>
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
                                    <td><a class="text-primary" href="{{ url('admin/vendor?action=vendor-details&id=').$item->vendor_id }}" target="_blank">{{ $item->store_name }}</a> </td>
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
                <h4 class="text-center text-danger mt-4 p-4">No Data found!</h4>
            @endif
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
    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background:#ff5f00;">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">BOOKING CONFIRMATION</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Booking Approved <span><i class="fa fa-check text-success"></i></span></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background:#ff5f00;">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">BOOKING STATUS</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Reason for rejection (Optional)</label>
                        <select name="productType" id="" class="form-select">
                            <option value="">Please select</option>
                            <option value="">Due to incomplete payment</option>
                            <option value="">Due to invalid contact details</option>
                            <option value="">Due to invalid XYZ reasons</option>
                            <option value="">Due to invalid ABC reasons</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger">Reject</button>
                    </div>
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
                    var url = "{!! url('admin/review-ratings&page=') !!}" + pagenumber;


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

            $('.viewCheckBox').click(function() {
                $(".hideRow").removeClass('d-none');
                $(this).addClass('d-none');
                $('.hideCheckBox').removeClass('d-none');
            });

            $('.hideCheckBox').click(function() {
                $(".hideRow").addClass('d-none');
                $(this).addClass('d-none');
                $('.viewCheckBox').removeClass('d-none');
                $('.form-check-input').attr('checked', false);
            });
        });
    </script>
@endsection
