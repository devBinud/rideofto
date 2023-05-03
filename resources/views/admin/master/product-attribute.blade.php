@extends('admin.layout', [
    'pageTitle' => 'Product Attribute',
    'currentPage' => 'productAttr',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Product Attribute</li>
@endsection

@section('custom-css')
@endsection

@section('body')

    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary"> Add
                    Attribute</button>
            </div>
            @if (count($productsAttr) > 0)
                <div class="table table-responsive ">
                    <table class="table table-bordered text-center">
                        <thead class="bg-dark text-uppercase ">
                            <th class="text-white">#</th>
                            <th class="text-white">Product Type</th>
                            <th class="text-white">Attribute Name</th>
                            <th class="text-white">Action</th>

                        </thead>
                        <tbody>
                            @foreach ($productsAttr as $item)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $item->product_type }}</td>
                                    <td>{{ $item->product_attr_name }}</td>
                                    <td class="w-25">
                                        <a type="button" class="btn btn-primary btn-sm editProductAttrBtn"
                                            attr-id="{{ $item->id }}" data-bs-toggle="modal"
                                            data-bs-target="#editProductAttributeModal">
                                            <i class="text-white fa fa-edit"></i>
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm deleteAttibute"
                                            data-id="{{ $item->id }}">
                                            <i class="text-white fa fa-trash" ></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div id="paginationBox" class="my-5"></div>
            @else
                <h4 class="text-center text-danger mt-4 p-4">No Record Found!</h4>
            @endif
        </div>
    </div>


    <!-- START PRODUCT ATTRIBUTE-->
    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Add Attribute</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/master?action=product-attribute') }}" method="POST"
                        enctype="multipart/form-data" id="addAttr">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="form-label required">Product Type</label>
                                <select name="productType" id="" class="form-select">
                                    <option value="">Please select</option>
                                    @foreach ($products as $item)
                                        <option value="{{ $item->id }}">{{ $item->product_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="" class="form-label required">Attribute Name</label>
                                <input type="text" name="attrName" id="" class="form-control"
                                    placeholder="Enter attribute name">
                            </div>
                        </div>
                        <div class="float-end mt-2">
                            <button class="btn btn-primary" type="submit" id="addAttr1">Save</button>
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PRODUCT ATTRIBUTE-->

    <!-- START PRODUCT ATTRIBUTE PARTIALS-->
    <div class="modal fade bd-example-modal-xl" id="editProductAttributeModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Edit Attribute</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editProductAttributePartialsBtn" style="min-height: 150px"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PRODUCT ATTRIBUTE PARTIALS-->
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#paginationBox").pxpaginate({
                currentpage: {{ $productsAttr->currentPage() }},
                totalPageCount: {{ ceil($productsAttr->total() / $productsAttr->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/master?action=product-attribute&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });

            // Add Product Attribute
            $('#addAttr').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#addAttr1");

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
                            swal('Success', data.message, 'success');
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

            // Delete Product Attribuite
            $('.deleteAttibute').click(function() {
                let attrId = $(this).attr('data-id');

                swal({
                        title: "Are you sure?",
                        text: "Do you want to delete this data !",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "{{ url('admin/master?action=delete-product-attr') }}",
                                type: 'post',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    attrId: attrId,
                                },
                                success: function(data) {
                                    if (!data.success) {
                                        if (data.data != null) {
                                            $.each(data.data, function(id, error) {
                                                $('#' + id).text(error);
                                            });
                                        } else {
                                            swal('Oops...', data.message, 'error');
                                            setTimeout(() => {
                                                window.location.reload();
                                            }, 5000);
                                        }
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
                    })
            });


            // START PARTIALS FOR PRODUCT ATTRIBUTE
            $(document).on('click', '.editProductAttrBtn', function(e) {
                e.preventDefault();

                $('#editProductAttributePartialsBtn').html('<h5 class="text-center">Please wait...</h5>')

                var attrId = $(this).attr('attr-id');

                var url = "{{ url('admin/master?action=edit-product-attribute') }}";
                $.get(url + "&id=" + attrId, function(data) {
                    $('#editProductAttributePartialsBtn').html(data.html);
                });
            });
            // END PARTIALS FOR PRODUCT ATTRIBUTE

        });
    </script>
@endsection
