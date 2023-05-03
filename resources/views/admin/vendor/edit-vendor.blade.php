@extends('admin.layout', [
    'pageTitle' => 'Edit Vendor',
    'currentPage' => 'vendor',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Edit Vendor</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    <div class="card">
        <div class="card-body">
            <form action="{{ url('admin/vendor?action=edit-vendor') }}" method="POST" id="editVendor"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="vendorId" value="{{$vendorId}}">
                <div class="row">
                    <div class="col-md-8 px-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label required">Store Name</label>
                                <input type="text" name="sName" class="form-control" value="{{ $data->store_name }}"
                                    placeholder="Enter store name">
                            </div>


                            <div class="col-md-6 ">
                                <label for="" class="form-label required">Phone Number</label>
                                <input type="text" name="phone" class="form-control" maxlength="10"
                                    value="{{ $data->store_phone }}" placeholder="Enter phone number" readonly>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email"
                                    value="{{ $data->store_email }}">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="" class="form-label required">City / Town</label>
                                <select name="cityId" id="" class="form-select">
                                    <option value="">Please select</option>
                                    @foreach ($city as $item)
                                        <option @if ($data->city_town_id == $item->id) selected @endif
                                            value="{{ $item->id }}">{{ $item->city_town }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="" class="form-label required">Postal Code</label>
                                <input type="text" name="postalcode" class="form-control" maxlength="6"
                                    value="{{ $data->postal_code }}" placeholder="Enter postal code">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="" class="form-label required">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $data->address }}"
                                    placeholder="Enter Address">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="" class="form-label required">Latitude</label>
                                <input type="text" name="latitude" class="form-control" value="{{ $data->latitude }}"
                                    placeholder="Enter latitude">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="" class="form-label required">Longitude</label>
                                <input type="text" name="logitude" class="form-control" value="{{ $data->longitude }}"
                                    placeholder="Enter longitude">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="" class="form-label required">Delivery Availability</label>
                                <select name="delivery" id="" class="form-select avl">
                                    <option value="">Please select</option>
                                    <option value="yes" @if ($data->is_delivery_available == 'yes') selected @endif>Yes</option>
                                    <option value="no" @if ($data->is_delivery_available == 'no') selected @endif>No</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2 @if ($data->is_delivery_available == 'no' && $data->max_delivery_distance == null) d-none @endif dist">
                                <label for="" class="form-label">Max Delivery Distance</label>
                                <input type="text" name="distance" class="form-control"
                                    placeholder="Enter msx delivery distance (in meters)"
                                    value="{{ $data->max_delivery_distance }}">
                            </div>


                        </div>

                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="card p-2" style="border-radius: 10%">
                            <div class="card-header text-center">

                                <h5 class="text-dark required">Image</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-2" id="imgHolder" style="min-height: 120px;">

                                    @if(empty($store->store_image))

                                        <img src="{{ asset('./assets/images/head_amethyst.png') }}"
                                        style="width: 40%;border-radius:10%" alt="">

                                    @else
                                        <img src="{{ asset('assets/uploads/vendor-image').'/'.$data->store_image }}"
                                        style="width: 40%;border-radius:10%" alt="">

                                    @endif
                                </div>


                                <div class="col-md-12 pl-md-1 mt-2 mt-lg-0">
                                    <button class="btn btn-warning" id="btnUploadImg" type="button">
                                        Upload image</button>

                                </div>

                                <span class="error text-danger text-center" id="imgErr"></span>
                            </div>
                            <input type="file" accept='image/jpeg,image/gif,image/png' class="d-none" name="img_file"
                                id="imgFile">
                            <input type="hidden" name="img_text" id="imgText">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label required">Owner Name</label>
                        <input type="text" name="ownerName" class="form-control" value="{{ $data->owner_name }}"
                            placeholder="Enter owner name" required>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label required">Owner Number</label>
                        <input type="text" name="ownerPhone" class="form-control" maxlength="10" value="{{ $data->owner_phone }}"
                            placeholder="Enter phone number" required>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label">Owner Email</label>
                        <input type="email" name="ownerEmail" class="form-control" value="{{ $data->owner_email }}"
                            placeholder="Enter email">
                    </div>
                </div>
                <div class="float-end mt-4">
                    <button type="submit" class="btn btn-primary" id="editVendor1">Update</button>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#btnUploadImg').click(function() {
                $('#imgFile').click();
            });

            const width = 240;
            const height = 240;

            // check max upload file size
            function isValidFileSize(target) {

                var maxUploadSize = "{{ Config::get('constants.max_upload_file_size.in_byte', 2048000) }}";
                var maxUploadSizeMB = "{{ Config::get('constants.max_upload_file_size.in_mb', 2) }}";

                if (target.files[0].size > maxUploadSize) {
                    target.value = "";
                    alert("Maximum file size supported is " + maxUploadSizeMB + " MB");
                    return false;
                };

                return true;
            }
            // image preview
            $('#imgFile').change(function() {
                if (!isValidFileSize(this)) {
                    return;
                }
                var src = URL.createObjectURL(this.files[0]);
                $('#imgHolder').html('<img src="' + src + '" style="max-width: ' + width +
                    'px; max-height: ' + height + 'px;"/>');
            });
            $('.avl').change(function(e) {
                let avail = $(this).val();
                if (avail == 'yes') {
                    $('.dist').removeClass('d-none');
                } else {
                    $('.dist').addClass('d-none');
                }
            });

            $('#editVendor').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var submit = $("#editVendor1");

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
                        alert(data.message);
                    } else {
                        alert(data.message);
                        // location.reload();
                        window.location.replace("{!! url('admin/vendor?action=vendor-list') !!}") ;
                    }
                },
                complete: function() {
                    submit.attr('disabled', false).html('Update');
                }
            });
        });
        });
    </script>
@endsection
