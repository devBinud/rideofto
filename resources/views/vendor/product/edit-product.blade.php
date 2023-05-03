@extends('vendor.layout', [
    'pageTitle' => 'Edit Product',
    'currentPage' => 'allProducts',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Edit Products</li>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        input[type="file"] {
            display: block;
        }

        .imageThumb {
            max-height: 75px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }

        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }

        .remove {
            display: block;
            background: #444;
            border: 1px solid black;
            color: rgb(247, 12, 12);
            text-align: center;
            cursor: pointer;
        }

        .remove:hover {
            background: white;
            color: black;
        }
    </style>
@endsection

@section('body')
    <div class="card">
        <div class="card-body px-4">
            <a href="{{ url('vendor/product?action=all-product') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i>
                Back</a>
            <hr>
            <form method="post" action="{{ url('vendor/product?action=edit-product') }}" id="editProductForm"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $productdata->id }}">
               
                <div class="row mt-4">
                    <div class="col-md-2">
                        <label for="" class="form-label required">Product Type</label>
                        <select name="productTypeId" class="form-select">
                            <option value="{{ $productdata->product_type_id }}">
                                {{ $productdata->product_type }}</option>
                        </select>
                    </div>
                    <div class="col-md-10">
                        <label class="mb-2 form-label">Category</label>
                        <select class="select2 mb-3 select2-multiple cat" name="catrgories[]" style="width: 100%"
                            multiple="multiple" data-placeholder="Choose">
                            <optgroup label="Product Categories" class="">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" @if (in_array($item->id, explode(',', $productdata->product_category_ids))) selected @endif>
                                        {{ $item->product_category }}</option>
                                @endforeach
                            </optgroup>

                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="" class="form-label required">Product Name</label>
                        <input type="text" name="productName" id="productName" class="form-control"
                            placeholder="Enter product name" value="{{ $productdata->product_name }}">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="" class="form-label required">Product Slug</label>
                        <input type="text" name="productSlug" id="productSlug" class="form-control"
                            value="{{ $productdata->product_slug }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label required">Picture</label>
                        <input type="file" name="picture" id="picture" class="form-control"
                            accept='image/jpeg,image/jpg,image/png'>
                        <div class="text-center mt-2 col-md-2">
                            <img style="width:50px;height:50px;"
                                src="{{ asset('assets/uploads/product-image/' . $productdata->product_thumbnail) }}">
                            <input type="hidden" name="old_picture" value="{{ $productdata->product_thumbnail }}">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label">Extra Images</label>
                        <input type="file" name="extraImage[]" id="extra" class="form-control"
                            accept='image/jpeg,image/jpg,image/png' multiple>
                        <div class="row g-3 mt-2">
                            @foreach (explode(',', $productdata->product_images) as $oldExtraImg)
                                @if ($productdata->product_images > 0)
                                    <div class="col-md-2 text-center">
                                        <img style="width:50px;height:50px;"
                                            src="{{ asset('assets/uploads/product-image/' . $oldExtraImg) }}">
                                        <input type="hidden" name="old_extraImg[]" value="{{ $oldExtraImg }}">
                                        <button type="button"
                                            class="btn btn-link text-danger btn-sm delete-image rounded-circle"
                                            aria-label="Close">
                                            Remove
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="" class="form-label required">Intial Stock</label>
                        <input type="number" class="form-control" name="initialStock" placeholder="Enter initial stock"
                            value="{{ $productdata->initial_stock }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-2">
                        <label for="" class="form-label required">Description</label>
                        <textarea id="basic-conf" name="product_desc">{{ $productdata->product_description }}</textarea>
                    </div>


                </div>
                <hr>
                <h5 class="text-dark mt-3">Product Details:</h5>
                <hr>
                @foreach ($productDetails as $details)
                    <div class="row">
                        <input type="hidden" name="prev_product_details[]" value="{{ $details->id }}">
                        {{-- <div class="col-md-4 mt-2">
                            <label for="" class="form-label">{{ $details->product_attr_name }}</label>
                            <select name="attributeId[]" class="form-select" id="">
                                <option value="{{ $details->product_attr_id }}" selected>
                                    {{ $details->product_attr_name }}</option>
                            </select>
                        </div> --}}
                        <div class="col-md-4 mt-2">
                            <input type="hidden" name="attributeId[]" value="{{ $details->product_attr_id }}">
                            <label for="" class="form-label">{{ $details->product_attr_name }} Attribute
                                Value</label>
                            <input type="text" name="atributeValue[]" class="form-control"
                                placeholder="Enter attribute value" value="{{ $details->attribute_value }}">
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="" class="form-label">Unit (if applicable)</label>
                            <select name="unitId[]" class="form-select" id="">
                                <option value="">Please select</option>
                                @foreach ($unit as $u)
                                    <option value="{{ $details->attribute_value_unit_id }}"
                                        @if ($details->attribute_value_unit_id == $u->id) selected @endif>
                                        {{ $u->unit }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                @endforeach
                <hr>
                <h5 class="text-dark mt-3">Product Pricing:</h5>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="form-label">Currency</label>
                        <select class="form-select" name="currency" id="">
                            <option value="{{ $productdata->currency }}" selected>{{ $productdata->currency }} </option>
                            <option value="DKK">DKK</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Additional Charge</label>
                        <input type="text" name="addCharge" class="form-control"
                            placeholder="Enter additional charge" value="{{ $productdata->min_charge }}">
                    </div>
                    @if ($productdata->product_type_id == 1)
                        <div class="col-md-3">
                            <label for="" class="form-label">Depositum if need</label>
                            <input type="text" name="deposite_price" class="form-control" placeholder="Enter price"
                                value="{{ $productdata->deposite_price }}">
                        </div>
                        <div class="col-md-3">
                            <label for="" class="form-label">Insurance if need – paid in bike shop
                            </label>
                            <input type="text" name="insurance_price" class="form-control" placeholder="Enter price"
                                value="{{ $productdata->insurance_price }}">
                        </div>
                    @endif
                    @if($productdata->product_type_id == 2)
                    <input type="hidden" name="planUnitAcc" value="hour">
                    <div class="col-md-4">
                        <label for="" class="form-label">Price</label>
                        <input type="text" name="priceAcc" class="form-control" value="{{$vendorProductPricing[0]->price}}">
                    </div>
                    @endif
                </div>
                @if($productdata->product_type_id == 1)
                <div class="row mt-3">
                    @foreach ($vendorProductPricing as $data)
                        <input type="hidden" name="prev_product_price[]" value="{{ $data->id }}">
                        @if ($data->pricing_plan_unit == 'hour')
                            <div class="col-md-3">
                                <input type="hidden" name="planUnit[]" value="hour">
                                <label for="" class="form-label">Hour Price</label>
                                <input type="text" name="price[]" class="form-control" placeholder="Enter price"
                                    value="{{ $data->price }}">
                            </div>
                        @endif
                        @if ($data->pricing_plan_unit == 'day')
                            <div class="col-md-3">
                                <input type="hidden" name="planUnit[]" value="day">
                                <label for="" class="form-label">Day Price</label>
                                <input type="text" name="price[]" class="form-control" placeholder="Enter price"
                                    value="{{ $data->price }}">
                            </div>
                        @endif

                        @if ($data->pricing_plan_unit == 'week')
                            <div class="col-md-3">
                                <input type="hidden" name="planUnit[]" value="week">
                                <label for="" class="form-label">Week Price</label>
                                <input type="text" name="price[]" class="form-control" placeholder="Enter price"
                                    value="{{ $data->price }}">
                            </div>
                        @endif

                        @if ($data->pricing_plan_unit == 'month')
                            <div class="col-md-3">
                                <input type="hidden" name="planUnit[]" value="month">
                                <label for="" class="form-label">Month Price</label>
                                <input type="text" name="price[]" class="form-control" placeholder="Enter price"
                                    value="{{ $data->price }}">
                            </div>
                        @endif
                    @endforeach

                </div>
                @endif
                <!-- Start IS Home Delivery -->
                @if ($productdata->is_home_delivery > 0)
                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isHomeDelivery" name="is_home_delivery"
                                value="1" checked>
                            <label class="form-check-label" for="Is Home Delivery">
                                Is Home Delivery
                            </label>
                        </div>
                        @php
                            $km = $productdata->max_delivery_distance / 1000;
                        @endphp

                        <div class="row mt-2" id="isHomeDeliveryDiv">
                            <div class="col-md-4 py-1">
                                <label for="aadhar" class="form-label">Max Distance (km) </label>
                                <input type="text" class="form-control" name="maxdistance"
                                    placeholder="Enter max distance  in kelo meter" value="{{ $km }}">
                            </div>
                            <div class="col-md-4 py-1">
                                <label for="aadhar" class="form-label">Delivery Charge/km </label>
                                <input type="text" class="form-control" name="delivery_charge"
                                    placeholder="Enter Delivery Charge" value="{{ $productdata->delivery_charge }}">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isHomeDelivery" name="is_home_delivery"
                                value="1">
                            <label class="form-check-label" for="Is Home Delivery">
                                Is Home Delivery
                            </label>
                        </div>

                        <div class="row d-none mt-2" id="isHomeDeliveryDiv">
                            @php
                                $km = $productdata->max_delivery_distance / 1000;
                            @endphp
                            <div class="col-md-4 py-1">
                                <label for="aadhar" class="form-label">Max Distance (km) </label>
                                <input type="text" class="form-control" name="maxdistance"
                                    placeholder="Enter max distance  in kelo meter" value="{{ $km }}">
                            </div>
                            <div class="col-md-4 py-1">
                                <label for="aadhar" class="form-label">Delivery Charge/km </label>
                                <input type="text" class="form-control" name="delivery_charge"
                                    placeholder="Enter Delivery Charge">
                            </div>
                        </div>
                    </div>
                @endif
                <!-- ENd IS Home Delivery -->

                @if ($productdata->product_type_id == 1)
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
                                        <option value="{{ $item->id }}"
                                            @if (in_array($item->id, explode(',', $productdata->related_accessories))) selected @endif>
                                            {{ $item->product_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>

                        </select>
                    </div>
                @endif


                <div class="float-end mt-3">
                    <button class="btn btn-primary mt-2" id="addProduct1" type="submit">Update</button>
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
                </select>
            </div>
            <div class="col-md-1">
                <label for="" class="form-label text-dark">&nbsp;</label>
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

            $('#editProductForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#addProduct1");

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
                        submit.attr('disabled', false).html('Save');
                    }
                });
            });

            // Remove Extra Multiple Image
            $(".delete-image").click(function() {
                $(this).parent().remove();
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
            $('#productName').keyup(function() {
                var title = $(this).val();
                // alert(title);
                var slug = $('#productSlug');
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
    <script>
        $(document).ready(function() {
            // Extra Multiple  Image 
            if (window.File && window.FileList && window.FileReader) {
                $("#extra").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result +
                                "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove\">Remove</span>" +
                                "</span>").insertAfter("#extra");
                            $(".remove").click(function() {
                                $(this).parent(".pip").remove();
                            });

                            // Old code here
                            /*$("<img></img>", {
                              class: "imageThumb",
                              src: e.target.result,
                              title: file.name + " | Click to remove"
                            }).insertAfter("#files").click(function(){$(this).remove();});*/

                        });
                        fileReader.readAsDataURL(f);
                    }
                    console.log(files);
                });
            } else {
                alert("Your browser doesn't support to File API")
            }

            // Picture 
            if (window.File && window.FileList && window.FileReader) {
                $("#picture").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result +
                                "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove\">Remove</span>" +
                                "</span>").insertAfter("#picture");
                            $(".remove").click(function() {
                                $(this).parent(".pip").remove();
                            });

                            // Old code here
                            /*$("<img></img>", {
                              class: "imageThumb",
                              src: e.target.result,
                              title: file.name + " | Click to remove"
                            }).insertAfter("#files").click(function(){$(this).remove();});*/

                        });
                        fileReader.readAsDataURL(f);
                    }
                    console.log(files);
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
        });
    </script>
@endsection
