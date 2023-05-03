@extends('admin.layout', [
    'pageTitle' => 'Product Category',
    'currentPage' => 'product',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Product Category</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    

    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary">  Add Product
                    Category</button>
            </div>
            @if (count($productCategory) > 0)
                <div class="table table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="bg-dark text-uppercase">
                            <th class="text-white">#</th>
                            <th class="text-white">Product Type</th>
                            <th class="text-white">Category</th>
                            <th class="text-white">Action</th>

                        </thead>
                        <tbody>
                            @foreach ($productCategory as $data)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>{{ $data->product_type }}</td>
                                    <td>{{ $data->product_category }}</td>
                                    <td>
                                        <a type="button" class="btn btn-primary btn-sm categoryBtn"
                                            category-id="{{ $data->category_id }}" data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal">
                                            <i class="text-white fa fa-edit"></i>
                                        </a>
                                        <a type="button" class="btn btn-sm btn-danger deleteCategory"
                                            data-id="{{ $data->category_id }}">
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
                <h4 class="text-center text-danger mt-4 p-4">No product category found!</h4>
            @endif
        </div>
    </div>

    <!-- START ADD CATEGORY -->
    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Add Category</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/master?action=product-category') }}" method="POST"
                        enctype="multipart/form-data" id="addCat">
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
                                <label for="" class="form-label required">Category</label>
                                <input type="text" name="category" id="category" class="form-control"
                                    placeholder="Enter category">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="" class="form-label required">Category Slug</label>
                                <input type="text" name="categorySlug" id="categorySlug" class="form-control">
                            </div>
                        </div>
                        <div class="float-end mt-2">
                            <button class="btn btn-primary" type="submit" id="addCat1">Save</button>
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END ADD CATEGORY -->


    <!-- START EDIT CATEGORY -->
    <div class="modal fade bd-example-modal-xl" id="editCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Edit Category</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="categoryPartialsBtn" style="min-height: 250px"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END EDIT CATEGORY -->
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#paginationBox").pxpaginate({
                currentpage: {{ $productCategory->currentPage() }},
                totalPageCount: {{ ceil($productCategory->total() / $productCategory->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/master?action=product-category&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });

            // add Category
            $('#addCat').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#addCat1");

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

            // Delete Category 
            $('.deleteCategory').click(function() {
                let categoryId = $(this).attr('data-id');

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
                                url: "{{ url('admin/master?action=delete-category') }}",
                                type: 'post',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    categoryId: categoryId,
                                },
                                success: function(data) {
                                    if (!data.success) {
                                        if (data.data != null) {
                                            $.each(data.data, function(id, error) {
                                                $('#' + id).text(error);
                                            });
                                        } else {
                                            swal('Oops...', data.message, 'error');
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

            // Start Edit Category Partials 
            $(document).on('click', '.categoryBtn', function(e) {
                e.preventDefault();

                $('#categoryPartialsBtn').html('<h5 class="text-center">Please wait...</h5>')

                var categoryId = $(this).attr('category-id');

                var url = "{{ url('admin/master?action=edit-category') }}";
                $.get(url + "&id=" + categoryId, function(data) {
                    $('#categoryPartialsBtn').html(data.html);
                });
            });

            // End Edit Category Partials 

            // Product Category Slug
            $('#category').keyup(function() {
                var title = $(this).val();
                // alert(title);
                var slug = $('#categorySlug');
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
