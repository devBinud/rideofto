@extends('public.layout')
@section('title', 'Register')
@section('custom-css')
@endsection
@section('body')


    <!-- REGISTER SECTION STARTS -->

    <div class="login__body">
        <div id="login" class="login-form" style="margin-top: 143px;">
            <form action="{{ 'register' }}" method="POST" enctype="multipart/form-data" id="register1">
                @csrf
                <div class="avatar d-flex align-items-center" style="transform:scale(1.2)">
                    <img src="{{ asset('assets/img/section-images/avatar.png') }}" alt="Avatar">
                </div>
                <h2 class="text-center fw-bold">REGISTER</h2>
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Enter your name" required="required">

                </div>
                <div class="form-group mt-2">
                    <input type="text" class="form-control" name="email" placeholder="Enter your email" required="required">

                </div>
                <div class="form-group mt-2">
                    <input type="phone" class="form-control" name="phone" placeholder="Enter phone number"
                        maxlength="10" required="required">

                </div>
                <div class="form-group mt-2">
                    <input type="password" class="form-control" name="password" placeholder="Password">

                </div>
                <div class="form-group mt-2">
                    <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required="required">

                </div>
                <p style="margin-top:10px;">Already registered ? <a href="{{ url('login') }}"
                        style="color:rgba(206, 18, 18, 0.8)">Login Now</a></p>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="register1">Register Now</button>
                </div>
            </form>
        </div>

    </div>

@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('#register1').submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);
                var error = $('.error');
                var submit = $("#submit");

                // clear all error message
                error.text('');

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        // submit.attr('disabled', true).html('wait..');
                    },
                    success: function(data) {
                        if (!data.success) {

                            alert(data.message);

                        } else {
                            alert(data.message);
                            window.location.replace("{{ url('login') }}");
                        }
                    },
                    complete: function() {
                        // submit.attr('disabled', false).html('Save');
                    }
                })

            });
        });
    </script>

@endsection
