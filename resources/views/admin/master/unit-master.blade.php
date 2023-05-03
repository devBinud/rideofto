@extends('admin.layout', [
    'pageTitle' => 'Unit Master',
    'currentPage' => 'unit',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Unit Master</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    
    <div class="card">
        <div class="card-body">
            <div>
                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary">Add
                    Unit Master</button>
            </div>
            <div class="table table-responsive">
                <table class="table table-bordered text-center table-sm">
                    <thead class="text-uppercase bg-dark">
                        <tr>
                            <th class="text-white">#</th>
                            <th class="text-white w-50">Unit</th>
                            <th class="text-white w-25">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($unit) > 0)
                            @foreach ($unit as $item)
                                <tr>
                                    <td>
                                        {{ ++$sn }}
                                    </td>
                                    <td class="w-50">
                                        {{ $item->unit }}
                                    </td>
                                    <td class="w-25">
                                        <a type="button" class="btn btn-primary btn-sm unitData" data-id="{{ $item->id }}"
                                            data-unit="{{ $item->unit }}" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalPrimary1" title="Edit Unit">
                                            <i class="text-white fa fa-edit"></i>
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm delUnit" data-id="{{ $item->id }}">
                                            <i class="text-white fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">
                                    <h2 class="text-center">Record Not Found !</h2>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
            <div id="paginationBox" class="my-5"></div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Add Unit</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/master?action=unit-master') }}" method="POST" id="Unit"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="add">
                        <label for="" class="form-label">Unit</label>
                        <input type="text" class="form-control" name="unit" placeholder="Enter unit">
                        <div class="float-end mt-4">
                            <button type="submit" class="btn btn-primary" id="Unit1">Save</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Edit Unit</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/master?action=unit-master') }}" method="POST" id="editUnit"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="edit">
                        <input type="hidden" name="unitId" id="unitId" value="">
                        <label for="" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="unitName" name="unit"
                            placeholder="Enter unit" value="">
                        <div class="float-end mt-4">
                            <button type="submit" class="btn btn-primary" id="editUnit1">Update</button>
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
            $("#paginationBox").pxpaginate({
                currentpage: {{ $unit->currentPage() }},
                totalPageCount: {{ ceil($unit->total() / $unit->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/master?action=unit-master&page=') !!}" + pagenumber;


                    window.location.replace(url);
                },
            });

            $('.unitData').click(function() {
                let unitId = $(this).attr('data-id');
                let unit = $(this).attr('data-unit');
                $('#unitId').val(unitId);
                $('#unitName').val(unit);
            });

            // Add Unit
            $('#Unit').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#Unit1");

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

            // Unit Edit
            $('#editUnit').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $("#editUnit1");

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
                        submit.attr('disabled', false).html('Update');
                    }
                });
            });

            // Delete Unit
            $('.delUnit').click(function() {
                let unitId = $(this).attr('data-id');

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
                                url: "{{ url('admin/master?action=unit-master') }}",
                                type: 'post',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    unitId: unitId,
                                    type: 'delete-unit',
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
        });
    </script>
@endsection
