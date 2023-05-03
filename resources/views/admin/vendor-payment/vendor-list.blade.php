@extends('admin.layout', [
    'pageTitle' => 'Vendor List',
    'currentPage' => 'vendor_payment',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Vendor List</li>
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
        <div class="card-body">
            @if (count($vendorData) > 0)
                <div class="table table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="bg-secondary">
                            <th>#</th>
                            <th class="text-start">Store Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Last Payment</th>
                            <th>Action</th>

                        </thead>
                        <tbody>
                            @foreach ($vendorData as $data)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td class="text-start"><a class="text-primary"
                                            href="{{ url('admin/vendor?action=vendor-details&id=') . $data->id }}"
                                            target="_blank">{{ $data->store_name }}</a></td>
                                    <td>{{ $data->store_phone }}</td>
                                   
                                    <td>{{ $data->address }}</td>
                                    <td class="text-center">{{ empty($data->last_payment_date) ?'N/A' : date('d/m/Y',strtotime($data->last_payment_date)) }}</td>
                                    <td><a class="btn btn-sm btn-primary" href="{!! url('admin/vendor-payment?action=payment-list&vendor=').$data->id !!}" target="_blank">Details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="paginationBox" class="my-5"></div>
            @else
                <h4 class="text-center text-danger mt-4 p-4">No vendor data found!</h4>
            @endif
        </div>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $('document').ready(function() {
       
    
   

            $(document).on("click", ".paymentLisBtn", function() {
                let id = $(this).data('id');

                $('#vendorPaymentList').html('<h5 class="text-center">Please wait...</h5>')

                var url = "{{ url('admin/vendor-payment?action=vendor-payment-list') }}";

                $.get(url + "&vendorId=" + id,
                    function(data) {
                        $('#vendorPaymentList').html(data.html);
                    });
            });

            $("#paginationBox").pxpaginate({
                currentpage: {{ $vendorData->currentPage() }},
                totalPageCount: {{ ceil($vendorData->total() / $vendorData->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/vendor?action=all-vendor-list&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });

        

        });
    </script>
@endsection
