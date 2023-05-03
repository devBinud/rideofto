<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Rideofto | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom-style.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>

</head>

<body class="account-body">

    <!-- Log In page -->
    <div class="container">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="card" style="border-radius: 25px;">
                            <div class="card-body p-0 auth-header-box">
                                <div class="text-center p-3">
                                    <a href="#" class="logo logo-admin">
                                        {{-- <img src="{{ asset('assets/images/logo_white.png') }}" height="50" alt="logo" class="auth-logo"> --}}
                                    </a>
                                    <p class="text-muted  mb-0">Sign in to continue to Admin Portal.</p>
                                </div>
                            </div>
                            <div class="card-body p-0">

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active p-3" id="LogIn_Tab" role="tabpanel">
                                        <form class="form-horizontal auth-form" action="{{ url('admin/login') }}"
                                            id="form" method="POST" autocomplete="off">
                                            @csrf

                                            <div class="form-group mb-2">
                                                <label class="form-label required" for="emailorphone">Phone
                                                    number</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="phone"
                                                        id="phone" placeholder=" Phone number">
                                                </div>
                                            </div>
                                            <!--end form-group-->

                                            <div class="form-group mb-2">
                                                <label class="form-label required" for="password">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="password"
                                                        id="password" autocomplete="new-password"
                                                        placeholder="Enter password">
                                                </div>
                                            </div>
                                            <!--end form-group-->

                                            <div class="form-group row my-3">
                                                <div class="col-sm-6">
                                                    <div class="custom-control custom-switch switch-success">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customSwitchSuccess">
                                                        <label class="form-label text-muted"
                                                            for="customSwitchSuccess">Remember me</label>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                {{-- <div class="col-sm-6 text-end">
                                                    <a href="auth-recover-pw.html" class="text-muted font-13"><i
                                                            class="dripicons-lock"></i> Forgot password?</a>
                                                </div> --}}
                                                <!--end col-->
                                            </div>
                                            <!--end form-group-->

                                            <div class="form-group mb-0 row">
                                                <div class="col-12">
                                                    <button class="btn btn-primary w-100 waves-effect waves-light"
                                                        type="submit" id="btnSubmit">SIGN IN <i
                                                            class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end form-group-->
                                        </form>
                                        <!--end form-->

                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                            <div class="card-body bg-light-alt text-center">
                                <span class="text-muted d-none d-sm-inline-block">Rideofto ©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>
                                </span>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
    <!-- End Log In page -->




    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // form submit
            $('#form').submit(function(e) {
                e.preventDefault();

                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: method,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function() {
                        $('#btnSubmit').text("Please wait ...").attr('disabled', true);
                    },
                    success: function(data) {
                        if (!data.success) {
                            alert(data.message);
                        } else {
                            window.location.replace("{{ url('admin/dashboard') }}");
                            // alert(data.message);
                        }
                    },
                    complete: function() {
                        $('#btnSubmit').text("SIGN IN").attr('disabled', false);
                    }
                });
            });

        });
    </script>


</body>


</html>
