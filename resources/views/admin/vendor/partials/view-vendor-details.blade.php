<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Store Name:<span class="fw-bold">&nbsp;&nbsp; {{ $vendorData->store_name }}</span></h5>
                <h5>Phone Number:<span class="fw-bold">&nbsp;&nbsp; {{ $vendorData->store_phone }}</span></h5>
                <h5>Email:<span class="fw-bold">&nbsp;&nbsp; @if ($vendorData->store_email != null)
                            {{ $vendorData->store_email }}
                        @else
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N/A
                        @endif
                       {{-- {{1>2 ? "true" : "false"}} --}}
                    </span></h5>
                <h5>City/Town:<span class="fw-bold">&nbsp;&nbsp; {{ $vendorData->city_town }}</span></h5>
                <h5>Address:<span class="fw-bold">&nbsp;&nbsp; {{ $vendorData->address }}</span></h5>
                
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Postal Code:<span class="fw-bold">&nbsp;&nbsp; {{ $vendorData->postal_code }}</span></h5>
                <h5>Latitude:<span class="fw-bold">&nbsp;&nbsp; {{ $vendorData->latitude }}</span></h5>
                <h5>Longitude:<span class="fw-bold">&nbsp;&nbsp; {{ $vendorData->longitude }}</span></h5>
                <h5>Delivery Availability:<span class="fw-bold">&nbsp;&nbsp;
                            {{ $vendorData->is_delivery_available }}
                    </span></h5>
                <h5>Max Delivery Distance:<span class="fw-bold">&nbsp;&nbsp; @if($vendorData->max_delivery_distance != null)
                    {{ $vendorData->max_delivery_distance }} Metre @else  &nbsp; N/A @endif</span></h5>
            </div>
        </div> 
    </div>
    <div class="col-md-4">
        <div class="card p-2" style="border-radius: 10%">
            <div class="card-body text-center">
                <div class="mb-2" id="imgHolder" style="min-height: 120px;">

                    <img src="{{ asset('assets/uploads/vendor-image') . '/' . $vendorData->store_image }}"
                        style="width: 40%;border-radius:10%" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
