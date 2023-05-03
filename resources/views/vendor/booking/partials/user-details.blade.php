<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">

@switch($type)
    @case('bookingData')
        <h4 class="text-dark fw-bold px-2">Product Booking:</h4>
        <div class="table table-responsive">
            <table class="table table-bordered text-center">
                <tr>
                    <th class="fw-bold">Booking Id</th>
                    <td>{{ 'RIDEOF_' . $bookingData->id }}</td>
                    <th class="fw-bold">Name</th>
                    <td>{{ $bookingData->userName }}</td>
                    <th class="fw-bold">Email</th>
                    <td>{{ $bookingData->userEmail }}</td>
                    <th class="fw-bold">Phone</th>
                    <td>{{ $bookingData->userPhone }}</td>
                </tr>
                <tr>
                    <th class="fw-bold">Product Name</th>
                    <td>{{ $bookingData->product_name }}</td>
                    <th class="fw-bold">Product Image</th>
                    <td> <a type="button" target="_blank"
                            href="{{ asset('/assets/uploads/product-image/' . $bookingData->product_images) }}" alt=""
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="view">{{ $bookingData->product_images }}</a></td>
                    <th class="fw-bold">Pricing Plan</th>
                    <td>{{ ucfirst($bookingData->pricing_plan_unit) }}</td>
                    <th class="fw-bold">Price Per {{ $bookingData->pricing_plan_unit }}</th>
                    <td>{{ $bookingData->orginalProductPrice }} {{ $bookingData->originalCurrency }}</td>

                </tr>
                <tr>
                    <th class="fw-bold">Pickup Date</th>
                    <td>{{ date('d M,Y', strtotime($bookingData->pickup_date)) }}</td>
                    <th class="fw-bold">Pickup Time</th>
                    <td>{{ date('h:i A', strtotime($bookingData->pickup_time)) }}</td>
                    <th class="fw-bold">Return Date</th>
                    <td class="">{{ date('h:i A', strtotime($bookingData->return_date)) }}</td>
                    <th class="fw-bold">Return Time</th>
                    <td class="">{{ date('h:i A', strtotime($bookingData->return_time)) }}</td>

                </tr>
                <tr>
                    <th class="fw-bold">Ordered At</th>
                    <td>{{ date('d M,Y', strtotime($bookingData->created_at)) }}</td>
                    <th class="fw-bold">Booking Price</th>
                    <td class="">{{ $bookingData->booking_price }}&nbsp; {{ $bookingData->paidCurrency }}</td>
                    <th class="fw-bold">Discounted Amount</th>
                    <td>{{ $bookingData->discount_amount == null ? 'N/A' : $bookingData->discount_amount }}</td>
                    <th class="fw-bold">Total Price</th>
                    <td>{{ $bookingData->booking_price }}&nbsp;{{ $bookingData->paidCurrency }}</td>
                </tr>
                <tr>
                    <th class="fw-bold">Booking status</th>
                    <td>{{$bookingData->status}}</td>
                    @if($bookingData->status == 'canceled')
                    <th class="fw-bold"> Reason</th>
                    <td>{{$bookingData->cencel_reason}}</td>
                    <th>
                        <td></td>
                    </th>
                    <th>
                        <td></td>
                    </th>
                    @elseif($bookingData->status == 'rejected')
                    <th class="fw-bold">Reason</th>
                    <td>{{$bookingData->reject_reason}}</td>
                    <th>
                        <td></td>
                    </th>
                    <th>
                        <td></td>
                    </th>
                    @endif
                </tr>
                
            </table>
        </div>

        <h4 class="text-dark fw-bold px-2">Added accessories:</h4>
        @if (count($addedAccesories) > 0)
            <div class="table table-responsive table-sm">
                <table class="table table-bordered text-center">
                    <thead class="bg-light">
                        <th class="fw-bold">#</th>
                        <th class="fw-bold">Product Name</th>
                        <th class="fw-bold">Price</th>
                    </thead>
                    <tbody>
                        @foreach ($addedAccesories as $a)
                            <tr>
                                <td>{{ ++$sn }}</td>
                                <td>{{ $a->product_name }}</td>
                                <td>{{ $a->product_price }} {{ $a->currency }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h6 class="text-center mt-3 p-3">No accessories included by the user !</h6>
        @endif
        @if ($bookingData->status == 'pending')
            <form action="{{ url('vendor/booking?action=approve-reject-booking') }}" method="POST" id="rejectForm"
                class="d-none rejectForm2">
                @csrf
                <input type="hidden" name="type" value="reject">
                <input type="hidden" name="bookingId" value="{{ $bookingData->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Reason <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="reason" placeholder="Enter your reason here...">
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="submit" class="btn btn-info mt-1" id="rejectForm1">Apply</button>
                        <button type="button" class="btn btn-danger mt-1" id="cencel">Cencel</button>
                    </div>
                </div>
            </form>
            <div class="text-center">

                <button class="btn btn-primary hideReason" id="approve"><i class="fa fa-check" aria-hidden="true"></i>
                    Approve</button>
                <button type="button" class="btn btn-danger" id="rejectReasonShow"><i class="fa fa-close"
                        aria-hidden="true"></i>
                    Reject</button>
            </div>
        @endif
       
    @break

    @default
        <h4 class="text-center text-danger mt-4 p-4">Something went wrong! Please refresh the page and try again!</h4>
    @break;
@endswitch
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        $('#rejectReasonShow').click(function() {
            $(this).addClass('d-none');
            $('.rejectForm2').removeClass('d-none');
            $('.hideReason').addClass('d-none');
        });

        $('.hideReason').click(function() {
            // $(this).addClass('d-none');
            $('.rejectForm2').addClass('d-none');
        });

        $('#cencel').click(function() {
            $('.rejectForm2').addClass('d-none');
            $('.hideReason').removeClass('d-none');
            $('#rejectReasonShow').removeClass('d-none');
        });

        $('#rejectForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var submit = $("#rejectForm1");

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    submit.attr('disabled', true).html('Please wait..');
                },
                success: function(data) {
                    if (!data.success) {
                        swal('Oops...', data.message, 'error');
                    } else {
                        swal('Success!', data.message, {
                                            icon: "success",
                                        });
                                        // swal('Success', data.message, 'success');
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2000);
                        // window.location.replace("{!! url('vendor/product?action=all-product') !!}");
                    }
                },
                complete: function() {
                    submit.attr('disabled', false).html('Apply');
                }
            });
        });

        $('#approve').click(function() {
            // alert(1);
            let bookingId = {{ $bookingData->id }};
            // alert(bookingId);
            var result = confirm("Do you want to approve this data?");
            if (result) {
                $.ajax({
                    url: "{{ url('vendor/booking?action=approve-reject-booking') }}",
                    type: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bookingId: bookingId,
                        type: 'approve',
                    },
                    success: function(data) {
                        if (data.success) {
                            swal('Success!', data.message, {
                                            icon: "success",
                                        });
                                        // swal('Success', data.message, 'success');
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2000);
                        } else {
                            swal('Oops...', data.message, 'error');
                        }
                    }

                });
            }
        });
    });
</script>
