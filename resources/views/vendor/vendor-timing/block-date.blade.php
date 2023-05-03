@extends('vendor.layout', [
    'pageTitle' => 'Block Dates',
    'currentPage' => 'block_date',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Block Dates</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    <div class="card">
        <div class="card-body">
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add
                    Dates</button>
            </div>
            @if(count($dates) > 0)
            <div class="table table-responsive mt-2">
                <table class="table table-bordered text-center">
                    <thead class="bg-dark">
                        <tr>
                            <th class="text-white">#</th>
                            <th class="text-white">Block Date</th>
                            <th class="text-white">Date Range(Start date to end date)</th>
                            <th class="text-white">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dates as $d)
                        <tr>
                            <td>
                                {{++$sn}}
                            </td>
                            <td>
                                {{($d->block_date == null) ?  'N/A' : date('d M,Y',strtotime($d->block_date))}}
                            </td>
                            <td>@if($d->start_date_range == null && $d->end_date_range == null)
                                N/A
                                @else
                                From {{date('d M,Y',strtotime($d->start_date_range))}} to {{date('d M,Y',strtotime($d->end_date_range))}}
                                @endif
                            </td>
                            <td>
                                <a type="button" data-id="{{$d->id}}" class="btn btn-danger btn-sm del"><i class="fa fa-trash"></i></a>
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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Block Dates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="min-height: 250px">
                    <form action="{{ url('vendor/schedule?action=vendor-block-date') }}" method="POST" id="addDates"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input showBLockDate" type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault1" value="1" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Block Date
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input showDateRange" type="radio" name="flexRadioDefault"
                                        id="flexRadioDefault2" value="2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Closing Date Range
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 onlyBlockDate">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label required text-dark ">Date</label>
                                    <input type="date" name="date[]" class="form-control  inputdate">
                                </div>
                            </div>
                            <div class="appendHere">

                            </div>
                            
                            <div>
                                <button type="button" id="addMore" class="btn btn-info btn-sm">+ Add More</button>
                            </div>
                        </div>
                        <div class="row hideDateRange d-none mt-3">
                            <div class="col-md-6">
                                <label for="" class="form-label required">Start Date</label>
                                <input type="date" name="startDate" class="form-control inputdate">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label required">End Date</label>
                                <input type="date" name="endDate" class="form-control inputdate">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="addDates" id="addDates1" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="form-filed d-none">
        <div class="row">
            <div class="col-md-11">
                <div class="form-group">
                    <input type="date" name="date[]" class="form-control inputdate">
                </div>
            </div>
            <div class="col-md-1">
                <div>

                    <button type="button" class="delButton float-end btn btn-danger"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;
            $('.inputdate').attr('min', maxDate);
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#paginationBox").pxpaginate({
                currentpage: {{ $dates->currentPage() }},
                totalPageCount: {{ ceil($dates->total() / $dates->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('vendor/schedule?action=vendor-block-date&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });
            $('#addDates').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#addDates1");

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
                        submit.attr('disabled', false).html('Save');
                    }
                });
            });

            $(document).on('click', '#addMore', function() {
                let html = $('.form-filed').html();
                $('.appendHere').append(html);
            });

            $(document).on("click", '.delButton', function() {

                $(this).parent().parent().parent().remove();
            });

            $(document).on("click",'.del',function(){
                let id = $(this).attr('data-id');
                confirm1 = confirm('Do you want to delete this date ?');
                if (confirm1) {
                    $.ajax({
                        url: "{{ url('vendor/schedule?action=delete-block-date') }}",
                        type: "POST",
                        data: {
                           
                            _token: "{{ csrf_token() }}",
                            dateId: id,
                        },

                        beforeSend: function() {
                            
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
                            }
                        }
                    });
                }
            });

            $('.showDateRange').click(function() {
                $('.onlyBlockDate').fadeOut(1000);
                $('.hideDateRange').removeClass('d-none').fadeIn(500);
            });

            $('.showBLockDate').click(function() {
                // alert(1);
                $('.onlyBlockDate').fadeIn(1000);
                $('.hideDateRange').addClass('d-none');
            });
        });
    </script>
@endsection
