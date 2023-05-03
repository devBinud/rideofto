@extends('vendor.layout', [
    'pageTitle' => 'Edit Discount',
    'currentPage' => 'editdiscount',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Edit Discount</li>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('body')
    <div class="card">
        <div class="card-header">
            <a href="{{ url('vendor/discount?action=add-discount') }}" class="btn btn-primary btn-sm"><i
                    class="fas fa-arrow-left"></i> Back</a>
            {{-- <h4 class="card-title"><i class="fas fa-percent"></i> Edit Discount</h4> --}}
        </div>
        <!--end card-header-->
        <form action="{{ url('vendor/discount?action=edit-discount') }}" id="editDiscountForm" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $discountData->id }}">
                <div class="form-material">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="my-3 required">Discount Type</label>
                            <div>
                                <select class="form-select" name="discount_type" aria-label="Default select example">
                                    <option value="1" @if ($discountData->discount_type == 'flat') selected @endif>Flat</option>
                                    <option value="2" @if ($discountData->discount_type == 'percentage') selected @endif>Percentage
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-md-3">
                            <label class="my-3 required">Select Category Or Product</label>
                            <div>
                                <select class="form-select" id="selectproductorcategory" name="productorcategory"
                                    aria-label="Default select example">
                                    <option value="1" @if ($discountData->discount_product_or_category == 'Category') selected @endif>Category
                                    </option>
                                    <option value="2" @if ($discountData->discount_product_or_category == 'Product') selected @endif>Product
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="my-3 required">Select option</label>
                            <div>
                                <select class="select3 mb-3 select2-multiple" id="product_or_categoryId"
                                    name="product_or_categoryIds[]" style="width: 100%" multiple="multiple"
                                    data-placeholder="Choose">
                                    @if ($discountData->discount_product_or_category == 'Category')
                                        @foreach ($discountProductOrCategory as $item)
                                            <option value="{{ $item->id }}"
                                                @if (in_array($item->id, explode(',', $discountData->product_cat_ids))) selected @endif>
                                                {{ $item->product_category }}</option>
                                        @endforeach
                                    @elseif($discountData->discount_product_or_category == 'Product')
                                        @foreach ($discountProductOrCategory as $item)
                                            <option value="{{ $item->id }}"
                                                @if (in_array($item->id, explode(',', $discountData->product_ids))) selected @endif>
                                                {{ $item->product_name }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="my-3 required">Discount Amount</label>
                            <input type="text" class="form-control" placeholder="Enter discount amount"
                                value="{{ $discountData->discount }}" name="discount_amount">
                        </div>
                        <!--end col-->
                        <div class="col-md-4">
                            <label class="my-3 required">Start Date</label>
                            <input type="datetime-local" class="form-control" name="start_date"
                                value="{{ $discountData->starting_from }}">
                        </div>
                        <div class="col-md-4">
                            <label class="my-3 required">End Date</label>
                            <input type="datetime-local" class="form-control" name="end_date"
                                value="{{ $discountData->valid_till }}">
                        </div>
                        <!--end col-->
                    </div>

                    <button class="btn btn-primary my-3 float-end" id="btnSubmit"><i class="fas fa-paper-plane"></i>
                        Update</button>
                    <!--end row-->
                </div>
            </div>
        </form>
        <!--end card-body-->
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select3').select2({

            });

            // Edit Discount 
            $('#editDiscountForm').submit(function(e) {
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
                            swal('Oops...', data.message, 'error');
                        } else {
                            swal('Success!', data.message, {
                                icon: "success",
                            });
                            setTimeout(() => {
                                window.location.replace(
                                    "{{ url('vendor/discount?action=add-discount') }}"
                                    );
                            }, 2000);
                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Save');
                    }
                });
            });


            // when discount type selected
            $('#selectproductorcategory').change(function() {
                var discountFor = $(this).val();
                $('#product_or_categoryId').html(
                    '<option value="" selected disabled>Please select</option>');

                $.ajax({
                    url: "{{ url('vendor/discount/for?for=') }}" + discountFor,
                    type: "GET",
                    success: function(data) {
                        if (!data.success) {
                            alert(data.message);
                            return;
                        }

                        if (data != null) {
                            var discount = data.data;
                            console.log(discount);
                            $.each(discount, function(key, value) {
                                var discountVal = "";
                                switch (discountFor) {
                                    case '1':
                                        $('#product_or_categoryId').append(
                                            '<option value="' +
                                            value
                                            .category_id +
                                            '">' +
                                            value.product_category + '</option>');
                                        break;
                                    case '2':
                                        $('#product_or_categoryId').append(
                                            '<option value="' +
                                            value
                                            .id +
                                            '">' +
                                            value.product_name + '</option>');
                                        break;
                                }

                            });
                        }
                    },
                });
            });
        });
    </script>
@endsection
