@extends('vendor.layout', [
    'pageTitle' => 'Vendor profile',
    'currentPage' => 'vendorProfile',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Vendor Profile</li>
@endsection

@section('custom-css')

@endsection

@section('body')
    

<div class="card">
    <div class="card-body row">
        <div class=" col-md-12 vendor__profile__details text-center">
            <img src="{{ asset('assets/img/section-images/johnbike.png') }}" alt="profile-img" height="70vh">
            <h4 class="fw-bold" style="color:#ff5f00;">{{ $data->store_name }}</h4>
            <h5 class="text-dark"><i class="fa fa-map-pin me-2"  style="color:#ff5f00;"></i>{{ $data->region }}, {{ $data->city_town }}</h5>

            <div class=" text-center">
                {{-- <button type="button" class="btn btn-sm btn-primary">Vendor Details</button> --}}
                {{-- <a href="{{ url('admin/vendor?action=vendor-item-lists&id='.$id) }}" type="button" class="btn btn-sm btn-outline-primary">Item Lists</a>
                <a href="{{ url('admin/vendor?action=vendor-orders&id='.$id) }}" type="button" class="btn btn-sm btn-outline-primary">Orders</a> --}}
                {{-- <a href="{{ url('admin/vendor?action=vendor-review-ratings&id='.$id) }}" type="button" class="btn btn-sm btn-outline-primary">Review and Ratings</a> --}}
            </div>

        </div>
        <div class="col-md-12 mt-3" style="border:1px solid #dee4e7;border-radius:10px">
            <h5 class="text-center fw-bold text-uppercase col-12">Vendor Details</h5>
            <hr class="mt-0 mb-4">
            <div class="row">
                <div class="col-md-4">

                    <table class="table table-borderless">
                        <tr>
                            <td>Store Name</td>
                            <td>: {{ $data->store_name }}</td>
                        </tr>
                        <tr>
                            <td>Store Email</td>
                            <td>: {{ $data->store_phone }}</td>
                        </tr>
                        <tr>
                            <td>Store Phone</td>
                            <td>: {{ $data->store_email }}</td>
                        </tr>
                        <tr>
                            <td>Home Delivery</td>
                            <td>: @if($data->is_delivery_available == 'yes') Yes ,{{ $data->is_delivery_available }} km @else N/A @endif </td>
                        </tr>
                    </table>

                </div>
                <div class="col-md-4">

                    <table class="table table-borderless">
                        <tr>
                            <td>Owner Name</td>
                            <td>: {{ $data->owner_name }}</td>
                        </tr>
                        <tr>
                            <td>Owner Email</td>
                            <td>: {{ $data->owner_phone }}</td>
                        </tr>
                        <tr>
                            <td>Owner Phone</td>
                            <td>: {{ $data->owner_email }}</td>
                        </tr>
                    </table>

                </div>
                <div class="col-md-4">

                    <table class="table table-borderless">
                        <tr>
                            <td>Region</td>
                            <td>: {{ $data->region }}</td>
                        </tr>
                        <tr>
                            <td>City/Town</td>
                            <td>: {{ $data->city_town }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>: {{ $data->address.' , '.$data->postal_code }}</td>
                        </tr>
                        <tr>
                            <td><span class="btn btn-sm btn-info plot-map"
                                data-lat="{{ $data->latitude }}" data-long="{{ $data->longitude }}"
                                data-bs-toggle="modal" data-bs-target="#mapModal">View On Map</span></td>
                            <td></td>
                        </tr>
                    </table>

                </div>
            </div>
            

           
        </div>
        <div class="col-md-12 mt-2" style="border:1px solid #dee4e7;border-radius:10px">
            <h5 class="text-center fw-bold text-uppercase">Bank Details</h5>
            <hr class="mt-0 mb-4">

            <table class="table table-borderless">
                <tr>
                    <th width="9%">Bank Details</th>
                    <td width = "1%"> : </td>
                    <td>@if($data->bank_details == null)
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add</button>
                        @else
                        {{$data->bank_details}}  <button type="button" class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Update</button>
                        @endif
                    </td>
                    
                </tr>
            </table>
        </div>

        <div class="col-md-12 mt-2 d-none" style="border:1px solid #dee4e7;border-radius:10px">
            <h5 class="text-center fw-bold text-uppercase">Opening Hours</h5>
            <hr class="mt-0 mb-4">

            <table class="table table-bordered text-center">
                <tr class="table-light">
                    <th>#</th>
                    <th>Monday</th>
                    <th>Tuesday </th>
                    <th>Wednesday </th>
                    <th>Thursday </th>
                    <th>Friday </th>
                    <th>Saturday </th>
                    <th>Sunday </th>
                    
                </tr>
                <tr>
                    <td>Opening</td>
                    <td>{{ !empty($data->monday_opening) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }}</td>
                    <td>{{ !empty($data->tuesday_opening) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->wednesday_opening) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->wednesday_opening) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->friday_opening) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->saturday_opening) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->sunday_opening) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    
                </tr>

                <tr>
                    <td>Closing</td>
                    <td>{{ !empty($data->monday_closing) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }}</td>
                    <td>{{ !empty($data->tuesday_closing) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }}</td>
                    <td>{{ !empty($data->wednesday_closing) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->thursday_closing) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->friday_closing) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->saturday_closing) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    <td>{{ !empty($data->sunday_closing) ? date('H:i A',strtotime($data->monday_opening)) : 'N/A' }} </td>
                    
                </tr>
            </table>
        </div>
       
       
    </div>


</div>

<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="map-body">

               
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"> Bank Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{url('vendor/vendor-profile?action=add-bank-details')}}" method="POST" id="addBank">
            @csrf
            <div class="form-group">
                <label for="" class="form-label">Bank Details</label>
                <textarea name="bankDetails" class="form-control" id="" cols="30" rows="10" placeholder="Enter bank details here.....">
                    {{$data->bank_details}}
                </textarea>
            </div>
            <div class="float-end mt-2">
                <button type="submit" class="btn btn-primary" id="addBank1">Submit</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        $(document).on('click', '.plot-map', function() {
            var lat = $(this).data('lat');
            var long = $(this).data('long');
            var html = "<iframe style='width:100%;height:400px' src = https://maps.google.com/maps?q="+lat+","+long+"&hl=es;z=14&amp;output=embed></iframe>";

            $('#map-body').html(html) ;
        });
        
    </script>
    <script>
        $(document).ready(function(){
            $('#addBank').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#addBank1");

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
                                       
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2000);
                           
                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Submit');
                    }
                });
            });
        });
    </script>
@endsection
