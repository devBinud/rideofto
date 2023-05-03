@extends('vendor.layout', [
    'pageTitle' => 'Booking history',
    'currentPage' => 'bookingHistory',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Booking History</li>
@endsection

@section('custom-css')
@endsection

@section('body')


    <div class="card">
        <div class="card-body">
            @if (count($bookingHistory) > 0)
                <div class="table mt-3">
                    <table class="table table-bordered text-center table-responsive">
                        <thead class="text-uppercase bg-dark">
                            <tr>

                                <th class="text-white fw-bold">#</th>
                                <th class="text-white fw-bold">Booking Id</th>
                                <th class="text-white fw-bold">Name</th>
                                <th class="text-white fw-bold">Phone No</th>
                                <th class="text-white fw-bold">Email</th>
                                {{-- <th class="text-white fw-bold">Distance</th> --}}
                                <th class="text-white fw-bold">Pickup Date & Time</th>
                                <th class="text-white fw-bold">Return Date & Time</th>
                                <th class="text-white fw-bold">Ordered At</th>
                                <th class="text-white fw-bold">Payable Price</th>
                                <th class="text-white fw-bold">Status</th>
                                <th class="text-white fw-bold">Action</th>
                                {{-- <th class="text-white fw-bold">Accessories and Tax(Price)</th> --}}
                                {{-- <th class="text-white fw-bold">Total Payment</th> --}}

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookingHistory as $item)
                                <tr>
                                    <td class="px-3">{{ ++$sn }}</td>
                                    <td class="">{{ 'RIDEOF_' . $item->id }}</td>
                                    <td class="">
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                            data-userid="{{ $item->userId }}"
                                            class="btn btn-sm text-primary fw-bold viewUser"
                                            href="">{{ $item->username }}</a>
                                    </td>
                                    <td class="">{{ $item->userPhone }}</td>
                                    <td class="">{{ $item->userEmail }}</td>

                                    <td class="">{{ date('d M,Y', strtotime($item->pickup_date)) }}
                                        {{ date('h:i A', strtotime($item->pickup_date)) }}</td>
                                    <td class="">{{ date('d M,Y', strtotime($item->return_date)) }}
                                        {{ date('h:i A', strtotime($item->return_time)) }}</td>
                                    <td class="">{{ date('d M,Y', strtotime($item->created_at)) }}</td>
                                    <td class="">{{ $item->booking_price }} {{ $item->currency }}</td>
                                    <td>{{ ucfirst($item->status) }}</td>
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
                <h4 class="text-center text-danger mt-4 p-4">No pending request found!</h4>
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
@endsection


@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#paginationBox").pxpaginate({
                currentpage: {{ $bookingHistory->currentPage() }},
                totalPageCount: {{ ceil($bookingHistory->total() / $bookingHistory->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('vendor/booking?action=booking-history&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });

            $(document).on('click', '.viewUser', function(e) {
                e.preventDefault();
                $('#staticBackdropLabel').html('User Details');
                let userId = $(this).attr('data-userid');
                $('#appendHere').html('<h4 class="text-center p-3">Please wait...</h4>');
                let url = "{{ url('vendor/booking?action=get-user-details') }}";
                $.get(url + "&userId=" + userId + "&type=" + "viewUser", function(data) {
                    $('#appendHere').html(data.html);
                });
            });

            $(document).on('click', '.viewAll', function(e) {
                e.preventDefault();
                $('#staticBackdropLabel').html('Booking Details');
                let bookingId = $(this).attr('data-bookingid');
                $('#appendHere').html('<h4 class="text-center p-3">Please wait...</h4>');
                let url = "{{ url('vendor/booking?action=get-user-details') }}";
                $.get(url + "&bookingId=" + bookingId + "&type=" + "viewBooking" + "&status=" + null,
                    function(data) {
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
