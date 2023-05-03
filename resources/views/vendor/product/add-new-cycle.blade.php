@extends('vendor.layout', [
    'pageTitle' => 'Add New Cycle',
    'currentPage' => 'addCycle',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Add New Cycle</li>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('body')
    <div class="card">
        <div class="card-body px-4">
            <h5 class="text-dark">Product:</h5>
            <hr>
            <form action="{{ url('vendor/product?action=add-new-cycle') }}" method="POST" id="addNewCycleForm"
                enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                    <div class="col-md-12">
                        <label class="mb-2 form-label">Category</label>
                        <select class="select2 mb-3 select2-multiple cat" name="catrgories[]" style="width: 100%"
                            multiple="multiple" data-placeholder="Choose">
                            <optgroup label="Product Categories" class="">
                                @foreach ($categories as $item)
                                    @if ($item->product_type_id == 1)
                                        <option value="{{ $item->id }}">
                                            {{ $item->product_category }}</option>
                                    @endif
                                @endforeach
                            </optgroup>

                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="" class="form-label required">Product Name</label>
                        <input type="text" name="productName" id="product_name" class="form-control"
                            placeholder="Enter product name">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="" class="form-label required">Product Slug</label>
                        <input type="text" name="productSlug" id="product_lug" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="" class="form-label required">Description</label>
                        <textarea id="basic-conf" name="productDesc"></textarea>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label required">Picture</label>
                        <input type="file" name="thumbnail" class="form-control" accept='image/jpeg,image/jpg,image/png'>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label">Extra Images</label>
                        <input type="file" name="extraImage[]" class="form-control"
                            accept='image/jpeg,image/jpg,image/png' multiple>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label required">Intial Stock</label>
                        <input type="number" class="form-control" name="initialStock" placeholder="Enter initial stock">
                    </div>

                </div>
                <hr>
                <h5 class="text-dark mt-3">Product Details:</h5>
                <hr>
                @foreach ($attribute as $a)
                        <div class="row">
                            <div class="col-md-4 mt-2">
                               
                                    <input type="hidden" name="attributeId[]" value="{{ $a->id }}">
                              
                                <label for="" class="form-label">{{ $a->product_attr_name }} Attribute Value</label>
                                <input type="text" name="atributeValue[]" class="form-control"
                                    placeholder="Enter attribute value">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="" class="form-label">Unit (if applicable)</label>
                                <select name="unitId[]" class="form-select" id="">
                                    <option value="">Please select</option>
                                    @foreach ($unit as $u)
                                        <option value="{{ $u->id }}">{{ $u->unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                
                @endforeach
                {{-- <div id="appendHere">
                </div>
                <button type="button" class="btn btn-success mt-2 " id="addMore">+Add More</button> --}}

                <hr>
                <h5 class="text-dark mt-3">Product Pricing:</h5>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="form-label required">Currency</label>
                        <select class="form-select" name="currency" id="">
                            <option value="">Please select</option>
                            <option value="DKK">DKK</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label required">Additional Charge</label>
                        <input type="text" name="addCharge" class="form-control" placeholder="Enter additional charge">
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Deposite if need</label>
                        <input type="text" name="deposite_price" class="form-control" placeholder="Enter price">
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Insurance if need – paid in bike shop
                        </label>
                        <input type="text" name="insurance_price" class="form-control" placeholder="Enter price">
                    </div>
                </div>
                <div class="row mt-3">

                    <div class="col-md-3">
                        <input type="hidden" name="planUnit[]" value="hour">
                        <label for="" class="form-label">Hour Price</label>
                        <input type="number" name="price[]" class="form-control" placeholder="Enter price">
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="planUnit[]" value="day">
                        <label for="" class="form-label">Day Price</label>
                        <input type="number" name="price[]" class="form-control" placeholder="Enter price">
                    </div>


                    <div class="col-md-3">
                        <input type="hidden" name="planUnit[]" value="week">
                        <label for="" class="form-label">Week Price</label>
                        <input type="number" name="price[]" class="form-control" placeholder="Enter price">
                    </div>


                    <div class="col-md-3">
                        <input type="hidden" name="planUnit[]" value="month">
                        <label for="" class="form-label">Month Price</label>
                        <input type="number" name="price[]" class="form-control" placeholder="Enter price">
                    </div>

                </div>
                {{-- <div id="appendPriceDetails">
                </div>
                <button type="button" class="btn btn-success mt-2" id="addMorePrice">+Add More</button> --}}

                <div class="col-md-12 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="isHomeDelivery" name="is_home_delivery"
                            value="1">
                        <label class="form-check-label" for="Is Home Delivery">
                            Is Home Delivery
                        </label>
                    </div>

                    <div class="row d-none mt-2" id="isHomeDeliveryDiv">
                        <div class="col-md-4 py-1">
                            <label for="aadhar" class="form-label">Max Distance (km) </label>
                            <input type="text" class="form-control" name="maxdistance"
                                placeholder="Enter max distance  in kelo meter" value="{{ $maxdeliverydistance }}">
                        </div>
                        <div class="col-md-4 py-1">
                            <label for="aadhar" class="form-label">Delivery Charge/km </label>
                            <input type="text" class="form-control" name="delivery_charge"
                                placeholder="Enter Delivery Charge/km">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5 class="text-dark mt-3">Related Accessories:</h5>
                    <hr>
                    <label class="mb-2 form-label">Select Accessories</label>
                    <select class="select2 mb-3 select2-multiple" name="relatedAccessories[]" style="width: 100%"
                        multiple="multiple" data-placeholder="Select Accessories...">
                        <optgroup label="Select Accessories..." class="">
                            @foreach ($accessories as $item)
                                @if ($item->product_type_id == 2)
                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                @endif
                            @endforeach
                        </optgroup>

                    </select>
                </div>

                <div class="float-end mt-3">
                    <button class="btn btn-primary mt-2" id="btnSubmit" type="submit"><i
                            class="fas fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Product Details -->
    <div class="formField d-none">
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="" class="form-label required">Attribute</label>
                <select name="attributeId[]" class="form-select" id="">
                    <option value="">Plese select</option>
                    @foreach ($attribute as $a)
                        <option value="{{ $a->id }}">{{ $a->product_attr_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label required">Attribute Value</label>
                <input type="text" name="atributeValue[]" class="form-control" placeholder="Enter attribute value">
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Unit (if applicable)</label>
                <select name="unitId[]" class="form-select" id="">
                    <option value="">Please select</option>
                    @foreach ($unit as $u)
                        <option value="{{ $u->id }}">{{ $u->unit }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label for="" class="form-label text-dark required">&nbsp;</label>
                <div class="">

                    <button type="button" class="delButton btn-sm float-end btn btn-danger">
                        <i class="" data-feather="trash"></i></button>
                </div>
            </div>
        </div>
    </div>


    <!-- Product Pricing: -->
    <div class="priceField d-none">
        <div class="row mt-2">
            <div class="col-md-3">
                <label for="" class="form-label required">Plan Unit</label>
                <select class="form-select" name="planUnit[]" id="">
                    <option value="">Please select</option>
                    <option value="hour">Hour</option>
                    <option value="day">Day</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label required">Price</label>
                <input type="text" name="price[]" class="form-control" placeholder="Enter price">
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Additional Charge</label>
                <input type="text" name="addCharge[]" class="form-control" placeholder="Enter additional charge">
            </div>
            <div class="col-md-1">
                <label for="" class="form-label text-dark">&nbsp;</label>
                <div class="">
                    <button type="button" class="delButtonPrice btn-sm float-end btn btn-danger">
                        <i class="" data-feather="trash"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a City'
            });

            $(document).on("click", '#addMore', function() {
                let html = $('.formField').html();
                $('#appendHere').append(html);
            });

            $(document).on("click", '.delButton', function() {

                $(this).parent().parent().parent().remove();
            });

            $(document).on("click", '#addMorePrice', function() {
                let html = $('.priceField').html();
                $('#appendPriceDetails').append(html);
            });

            $(document).on("click", '.delButtonPrice', function() {

                $(this).parent().parent().parent().remove();
            });


            $('#addNewCycleForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#btnSubmit");

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
                            window.location.replace("{!! url('vendor/product?action=all-product') !!}");
                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Submit');
                    }
                });
            });


            // Is Home Delivery
            $("#isHomeDelivery").change(function() {
                // $(this).hide();
                var checked = $(this).is(':checked');
                // alert(checked);
                if (checked) {
                    $("#isHomeDeliveryDiv").removeClass('d-none');
                } else {
                    $("#isHomeDeliveryDiv").addClass('d-none');
                }
            });


            // Product Slug
            $('#product_name').keyup(function() {
                var title = $(this).val();
                // alert(title);
                var slug = $('#product_lug');
                // alert(slug);
                if (title.length > 0) {
                    $.get("{{ url('/generate-slug') }}", {
                        data: title,
                    }).done(function(data) {
                        slug.val(data);
                    });
                } else {
                    slug.val("");
                }
            });
        });
    </script>
@endsection
