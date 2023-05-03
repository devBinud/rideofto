@extends('admin.layout', [
    'pageTitle' => 'User List',
    'currentPage' => 'userlist',
])

@section('breadcrumb')
    <li class="breadcrumb-item active">User List</li>
@endsection

@section('custom-css')
<style>
    
</style>
@endsection

@section('body')
    <div class="card">
        <div class="card-body">
            @if (count($userData) > 0)
                <div class="table table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="bg-dark">
                            <th class="text-white">#</th>
                            <th class="text-white">Profile Picture</th>
                            <th class="text-white">Name</th>
                            <th class="text-white">Phone Number</th>
                            <th class="text-white">Email</th>
                            <th class="text-white">Created At</th>
                            <th class="text-white">Details</th>
                            <th class="text-white">Is Active</th>
                        </thead>
                        <tbody>
                            @foreach ($userData as $data)
                                <tr>
                                    <td>{{ ++$sn }}</td>
                                    <td>
                                        @if ($data->profile_pic > 0)
                                            <a target="_blank"
                                                href="{{ url('admin/user?action=user-details&id=' . $data->id) }}">
                                                <img src="{{ asset('assets/uploads/profile_picture_user') . '/' . $data->profile_pic }}"
                                                    class="rounded-circle" width="50px" height="50px">
                                            </a>
                                        @else
                                            <a target="_blank"
                                                href="{{ url('admin/user?action=user-details&id=' . $data->id) }}">
                                                <img src="{{ asset('assets/images/profile.png') }}" class="rounded-circle"
                                                    width="50px" height="50px">
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a target="_blank"
                                            href="{{ url('admin/user?action=user-details&id=' . $data->id) }}">
                                            {{ $data->name }}
                                        </a>
                                    </td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ date('d M, Y, G:i A', strtotime($data->created_at)) }}</td>
                                    <td>
                                        <a target="_blank"
                                            href="{{ url('admin/user?action=user-details&id=' . $data->id) }}"
                                            class="tippy-btn px-2">
                                            <i class="" data-feather="eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if ($data->is_active == 1)
                                            <button class="btn btn-success  btn-sm DeactiveUser"
                                                data-id="{{ $data->id }}">Active</button>
                                        @elseif($data->is_active == 0)
                                            <button class="btn btn-warning  btn-sm activeUser"
                                                data-id="{{ $data->id }}">Deactive</button>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div id="paginationBox" class="my-5"></div>
            @else
                <h4 class="text-center text-danger mt-4 p-4">No Record Found !</h4>
            @endif
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            //Pagination
            $("#paginationBox").pxpaginate({
                currentpage: {{ $userData->currentPage() }},
                totalPageCount: {{ ceil($userData->total() / $userData->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('admin/user?action=user-list&page=') !!}" + pagenumber;
                    window.location.replace(url);
                },
            });

            // Active User
            $(document).on('click', '.activeUser', function(e) {
                var userId = $(this).data('id');

                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to active User !');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('admin/user') }}",
                        type: "POST",
                        data: {
                            action: 'active-user',
                            _token: "{{ csrf_token() }}",
                            user_id: userId,
                            isActive: '1',
                        },

                        beforeSend: function() {
                            $(this).attr('disabled', true).html("Please wait..");
                        },
                        success: function(data) {
                            if (!data.success) {
                                swal('Oops...', data.message, 'error');
                                $(this).attr('disabled', false).html("Active");

                            } else {
                                swal('Success', data.message, 'success');
                                window.location.reload();
                            }
                        }
                    });
                } else {
                    $(this).attr('disabled', false).html("Active");
                }


            });


            // De Active User
            $(document).on('click', '.DeactiveUser', function(e) {
                var userId = $(this).data('id');

                var confirm1 = false;
                let _token = $('meta[name="csrf-token"]').attr('content');

                $(this).attr('disabled', true).html("Please wait..");

                confirm1 = confirm('Do you want to DeActive User !');

                if (confirm1) {
                    $.ajax({
                        url: "{{ url('admin/user') }}",
                        type: "POST",
                        data: {
                            action: 'active-user',
                            _token: "{{ csrf_token() }}",
                            user_id: userId,
                            isActive: '0',
                        },

                        beforeSend: function() {
                            $(this).attr('disabled', true).html("Please wait..");
                        },
                        success: function(data) {
                            if (!data.success) {
                                swal('Oops...', data.message, 'error');
                                $(this).attr('disabled', false).html("DeActive");

                            } else {
                                swal('Success', data.message, 'success');
                                window.location.reload();
                            }
                        }
                    });
                } else {
                    $(this).attr('disabled', false).html("DeActive");
                }


            });
        });
    </script>
@endsection
