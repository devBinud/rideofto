@extends('vendor.layout', [
    'pageTitle' => 'Vendor Timing',
    'currentPage' => 'vendor_timing',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Vendor Timing</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    <div class="card">
        <div class="card-body">
            @if ($vendorTiming == null)
                <h4 class="text-center text-danger m-5 p-5">No schedule found ! Please add your schedule
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModalPrimary">Click
                        Here</button>
                </h4>
            @else
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-primary">Opening Time</h3>
                            <h4>Monday Opening Time :<span class="fw-bold px-4">{{date('h:i A',strtotime($vendorTiming->monday_opening))}}</span></h4>
                            <h4>Tuesday Opening Time : <span class="fw-bold px-3">{{date('h:i A',strtotime($vendorTiming->tuesday_opening))}}</span></h4>
                            <h4>Wednesday Opening Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->wednesday_opening))}}</span></h4>
                            <h4>Thursday Opening Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->thursday_opening))}}</span></h4>
                            <h4>Friday Opening Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->friday_opening))}}</span></h4>
                            <h4>Saturday Opening Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->saturday_opening))}}</span></h4>
                            <h4>Sunday Opening Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->sunday_opening))}}</span></h4>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-primary">Closing Time</h3>
                            <h4>Monday Closing Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->monday_closing))}}</span></h4>

                            <h4>Tuesday Closing Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->tuesday_closing))}}</span></h4>

                            <h4>Wednesday Closing Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->wednesday_closing))}}</span></h4>

                            <h4>Thursday Closing Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->thursday_closing))}}</span></h4>

                            <h4>Friday Closing Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->friday_closing))}}</span></h4>

                            <h4>Saturday Closing Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->saturday_closing))}}</span></h4>

                            <h4>Sunday Closing Time : <span class="fw-bold">{{date('h:i A',strtotime($vendorTiming->sunday_closing))}}</span></h4>
                        </div>
                    </div>
                    <div class="float-start mt-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary">Click here to Update</button>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Schedule</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('vendor/schedule?action=vendor-timing') }}" method="POST" id="addTiming"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Monday Opening Time</label>
                                    <input type="time" name="mondayOpening" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->monday_opening}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Monday Closing Time</label>
                                    <input type="time" name="mondayClosing" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->monday_closing}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Tuesday Opening Time</label>
                                    <input type="time" name="tuesdayOpening" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->tuesday_opening}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Tuesday Closing Time</label>
                                    <input type="time" name="tuesdayClosing" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->tuesday_closing}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Wednesday Opening Time</label>
                                    <input type="time" name="wednesdayOpening" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->wednesday_opening}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Wednesday Closing Time</label>
                                    <input type="time" name="wednesdayClosing" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->wednesday_closing}}@endif">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Thursday Opening Time</label>
                                    <input type="time" name="thursdayOpening" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->thursday_opening}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Thursday Closing Time</label>
                                    <input type="time" name="thursdayClosing" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->thursday_closing}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Friday Opening Time</label>
                                    <input type="time" name="fridayOpening" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->friday_opening}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Friday Closing Time</label>
                                    <input type="time" name="fridayClosing" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->friday_closing}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Saturday Opening Time</label>
                                    <input type="time" name="saturdayOpening" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->saturday_opening}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Saturday Closing Time</label>
                                    <input type="time" name="saturdayClosing" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->saturday_closing}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Sunday Opening Time</label>
                                    <input type="time" name="sundayOpening" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->sunday_opening}}@endif">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label required">Sunday Closing Time</label>
                                    <input type="time" name="sundayClosing" class="form-control" value="@if($vendorTiming != null){{$vendorTiming->sunday_closing}}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="float-end mt-4">
                            @if($vendorTiming != null)
                            <button type="submit" class="btn btn-primary" id="addTiming1">Update</button>
                            @else
                            <button type="submit" class="btn btn-primary" id="addTiming1">Save</button>
                            @endif
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#addTiming').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#addTiming1");

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
                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Save');
                    }
                });
            });
        });
    </script>
@endsection
