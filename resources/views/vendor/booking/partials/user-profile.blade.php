<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-6 px-3 mb-1">
        <div class="card">
            <div class="card-body mb-3">
                <p class="text-dark mt-3">Name: <span class="fw-bold">{{ $userData->name }}</span></p>
                <p class="text-dark">Phone: <span class="fw-bold">{{ $userData->phone }}</span></p>
                <p class="text-dark">Email: <span class="fw-bold">{{ $userData->email }}</span></p>
                <p class="text-dark">Address 1: <span class="fw-bold">
                        @if ($userData->address01 == null)
                            N/A
                        @else
                            {{ $userData->address01 }}
                        @endif
                    </span></p>
                <p class="text-dark">Address 2: <span class="fw-bold">
                        @if ($userData->address02 == null)
                            N/A
                        @else
                            {{ $userData->address02 }}
                        @endif
                    </span></p>
                <p class="mb-3"></p>
            </div>
        </div>
    </div>

    <div class="col-md-4 px-3">
        <div class="card-header">
            <p class="text-center text-dark">User Profile Picture</p>
        </div>
        <div class="card p-2">

            <div class="card-body text-center">
                <div class="mb-2" id="imgHolder" style="min-height: 120px;">
                    @if ($userData->profile_pic != null)
                        <img src="{{ asset('./assets/uploads/profile_picture_user/' . $userData->profile_pic) }}"
                            style="width: 40%;" alt="">
                    @else
                        <h4>Profile picture is not available!</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1">

    </div>
</div>