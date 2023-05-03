@extends('admin.layout', [
    'pageTitle' => 'Vendor Payment List',
    'currentPage' => 'vendor_payment',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Vendor Payment List</li>
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
            @if (count($paymentData) > 0)
                <div class="table table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="bg-secondary">
                            <tr>
                                <th>#</th>
                                <th>Month Start</th>
                                <th>Month End</th>
                                <th>Total Transaction</th>
                                <th>Total Business Done</th>
                                <th>Vendor Percentage</th>
                                <th>Vendor Amount</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Details</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($paymentData as $data)
                            <tr>
                                <td>{{ 1+$sn++ }}</td>
                                <td>{{ date('d/m/Y',strtotime($data->month_start)) }}</td>
                                <td>{{ date('d/m/Y',strtotime($data->month_end)) }}</td>
                                <td>{{ $data->total_transaction }}</td>
                                <td>{{ $data->total_business }}</td>
                                <td>{{ $data->vendor_percentage }}</td>
                                <td>{{ $data->vendor_amount }}</td>
                                <td>
                                    <span class="@if($data->payment_status == 'pending') text-danger @else text-success @endif  text-uppercase">{{ $data->payment_status }}</span>
                                </td>
                                <td class="text-center">{{ empty($data->payment_date) ?'N/A' : date('d/m/Y',strtotime($data->payment_date)) }}</td>
                                <td><button class="btn btn-sm btn-success">Payment</button></td>
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


@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $('document').ready(function() {

            $("#paginationBox").pxpaginate({
                currentpage: {{ $paymentData->currentPage() }},
                totalPageCount: {{ ceil($paymentData->total() / $paymentData->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/vendor-payment?action=payment-list&vendor=$vendor&page=') !!}" + pagenumber;

                    window.location.replace(url);
                },
            });

        

        });
    </script>
@endsection
