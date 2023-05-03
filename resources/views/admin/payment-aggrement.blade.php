@extends('admin.layout', [
    'pageTitle' => 'Payment Aggrement',
    'currentPage' => 'Payment Aggrement',
])

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item active">Payment Aggrement</li>
@endsection

@section('custom-css')
@endsection

@section('body')
    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary">Add
                Agreement</button>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if (count($agreements) > 0)
                <div class="table table-responsive">
                    <table class="table table-bordered text-start">
                        <thead class="bg-secondary">
                            <th>#</th>
                            <th >Store Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            {{-- <th>Agreement Name</th> --}}
                            {{-- <th>Vendor (%)</th> --}}
                            {{-- <th>Valid From</th> --}}
                            <th>Valid Till</th>
                            {{-- <th>Vendor Accept At</th> --}}
                            {{-- <th>Status</th> --}}
                            <th class="text-center">Action</th>

                        </thead>
                        <tbody>

                            @foreach($agreements as $agreement)
                            <tr>
                                <td>{{ 1+$sn++ }}</td>
                                <td>{{ $agreement->store_name }}</td>
                                <td>{{ $agreement->store_phone }}</td>
                                <td>{{ $agreement->address }}</td>
                                {{-- <td>{{ $agreement->agreement_name }}</td> --}}
                                {{-- <td>{{ $agreement->vendor_percentage }}</td> --}}
                                {{-- <td>{{ $agreement->valid_from }}</td> --}}
                                <td>{{ explode(',',$agreement->agreement_valid_tills)[count(explode(',',$agreement->agreement_valid_tills))-1]}}</td>
                                {{-- <td>{{ $agreement->vendor_agree_at ?? '---' }}</td> --}}
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning agreement-renew-btn" data-vendorid = "{{ $agreement->vendor_id }}" data-vendorname = "{{ $agreement->store_name }}" data-bs-toggle="modal" data-bs-target="#agreementRenew">Renew</button>
    
                                    <button type="button" class="btn btn-sm btn-primary agreement-details-btn" data-vendorid = "{{ $agreement->vendor_id }}" data-vendorname = "{{ $agreement->store_name }}" data-bs-toggle="modal" data-bs-target="#agreementDetails">Details</button>
                                </td>

                                
                            </tr>
                            
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div id="paginationBox" class="my-5"></div>
            @else
                <h4 class="text-center text-danger mt-4 p-4">No vendor data found!</h4>
            @endif
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="exampleModalPrimary" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Add Agreement Data</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/payment-aggrement') }}" method="POST" class="addAgreement"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2 ">
                                <label for="" class="form-label required">Agreement Name</label>
                                <input type="text" name="agreement_name" class="form-control"
                                    placeholder="Enter agreement name">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label required">Vendor</label>
                                <select name="vendor" id="" class="form-select ">
                                    <option value="" selected disabled>Please select</option>
                                    @foreach ($vendorList as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label required">Vendor Percentage</label>
                                <input type="number" name="vendor_per" class="form-control"
                                    placeholder="Enter vendor percentage">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label required">Agreement Validity (days)</label>
                                <input type="number" name="agreement_validity" class="form-control"
                                    placeholder="Enter agreement validity in days">
                            </div>
                            

                            <div class="col-md-12 mb-2">
                                <label for="" class="form-label required">Agreement Governed By</label>
                                <input type="text" name="agreement_governed_by" class="form-control"
                                    placeholder="Enter Agreement Governed By">
                            </div>


                        </div>
                        
                        <div class="float-end mt-4">
                            <button type="submit" class="btn btn-primary addAgreementSubmit" id="">Save</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="agreementRenew" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Renew Agreement For <span class="vendorName"></span></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/payment-aggrement') }}" method="POST" class="addAgreement"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2 ">
                                <label for="" class="form-label required">Agreement Name</label>
                                <input type="text" name="agreement_name" class="form-control"
                                    placeholder="Enter agreement name">
                            </div>

                            <input type="hidden" name="vendor" id="vendorId" value="">


                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label required">Vendor Percentage</label>
                                <input type="number" name="vendor_per" class="form-control"
                                    placeholder="Enter vendor percentage">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label required">Agreement Validity (days)</label>
                                <input type="number" name="agreement_validity" class="form-control"
                                    placeholder="Enter agreement validity in days">
                            </div>
                            

                            <div class="col-md-12 mb-2">
                                <label for="" class="form-label required">Agreement Governed By</label>
                                <input type="text" name="agreement_governed_by" class="form-control"
                                    placeholder="Enter Agreement Governed By">
                            </div>


                        </div>
                        
                        <div class="float-end mt-4">
                            <button type="submit" class="btn btn-primary addAgreementSubmit" id="">Save</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="agreementDetails" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalPrimary1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Agreement Details For <span class="vendorName"></span></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/payment-aggrement') }}" method="POST" class="addAgreement"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2 ">
                                <label for="" class="form-label required">Agreement Name</label>
                                <input type="text" name="agreement_name" class="form-control"
                                    placeholder="Enter agreement name">
                            </div>

                            <input type="hidden" name="vendor" id="vendorId" value="">


                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label required">Vendor Percentage</label>
                                <input type="number" name="vendor_per" class="form-control"
                                    placeholder="Enter vendor percentage">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label required">Agreement Validity (days)</label>
                                <input type="number" name="agreement_validity" class="form-control"
                                    placeholder="Enter agreement validity in days">
                            </div>
                            

                            <div class="col-md-12 mb-2">
                                <label for="" class="form-label required">Agreement Governed By</label>
                                <input type="text" name="agreement_governed_by" class="form-control"
                                    placeholder="Enter Agreement Governed By">
                            </div>


                        </div>
                        
                        <div class="float-end mt-4">
                            <button type="submit" class="btn btn-primary addAgreementSubmit" id="">Save</button>
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
            // Pagination
            $("#paginationBox").pxpaginate({
                currentpage: {{ $agreements->currentPage() }},
                totalPageCount: {{ ceil($agreements->total() / $agreements->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/payment-aggrement&page=') !!}" + pagenumber;
                    window.location.replace(url);
                },
            });
        });
    </script>
    <script>
        $('document').ready(function() {

            $('.addAgreement').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var submit = $(".addAgreementSubmit");

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
                            location.reload();
                        }
                    },
                    complete: function() {
                        submit.attr('disabled', false).html('Save');
                    }
                });

            });

            $(document).on('click','.agreement-renew-btn',function(){
                var vendorId = $(this).data('vendorid') ;
                var vendorName = $(this).data('vendorname') ;

                $('#vendorId').val(vendorId) ;
                $('.vendorName').html(vendorName) ;
            })
        });
    </script>
@endsection

