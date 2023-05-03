    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center fixed-top">
        <div class="container d-flex justify-content-center justify-content-md-between">
          <div class="contact-info d-flex align-items-center">
          <div class="custom-select" style="width:70px;">
            <select>
                <option value="0">ENG</option>
                <option value="1">DAN</option>
            </select>
         </div>
         <div class="custom-select" style="width:200px;">
            <select>
                <option value="0">EURO</option>
                <option value="1">DKK</option>
            </select>
         </div>
              </div>
              <div class="contact-info d-flex align-items-center">
                <i class="bi bi-telephone d-none d-md-flex align-items-center "><span>+45 12321 21321</span></i>
                <i class="bi bi-envelope d-none d-md-flex align-items-center ms-4"><a
                        href="mailto:contact@example.com">example@gmail.in</a></i>
            </div>
        </div>
      </section>
      <!-- ======= Header ======= -->
      <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between" style="margin-top: 38px;">
    
          <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-lg-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{asset('assets/img/logo/logo.png') }}" alt="">
            {{-- <h1 class="d-lg-block d-none">Rideofto<span>.</span></h1> --}}
          </a>
    
          <nav id="navbar" class="navbar">
            <ul>
              <li><a href="{{ url('/') }}">Home</a></li>
              <li><a href="{{ url('about-us') }}">About</a></li>
              <li><a href="{{url('/terms-and-conditions')}}">Terms and Conditions</a></li>
              <li><a href="{{ url('/#contact') }}">Contact</a></li>
              {{-- <li>@if (session()->has('user_name')) A @else B @endif</li> --}}
            </ul>
          </nav><!-- .navbar -->
          
          @if (session()->has('user_name'))
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                      <img src="{{ asset('assets/img/section-images/profile.png') }}" alt="Profile" class="rounded-circle">
                      <span class="d-none d-md-block dropdown-toggle ps-0">{{ Session::get('user_name') }}</span>
                  </a>
         <!-- End Profile Iamge Icon -->
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                      <li class="dropdown-header">
                          <h6>{{ Session::get('user_name') }}</h6>
                          {{-- <span>Copenhagen, Denmark</span> --}}
                      </li>
                      <li>
                          <hr class="dropdown-divider">
                      </li>
    
                      <li>
                          <a class="dropdown-item d-flex align-items-center" href="{{ url('bike?action=my-booking&type=profile') }}">
                              <i class="bi bi-person"></i>
                              <span>My Profile</span>
                          </a>
                      </li>
                      <li>
                          <a class="dropdown-item d-flex align-items-center" href="{{ url('bike?action=my-booking&type=booking') }}">
                              <i class="bi bi-bicycle"></i>
                              <span>My booking</span>
                          </a>
                      </li>
                      <li>
                          <a class="dropdown-item d-flex align-items-center" href="{{ url('logout') }}">
                              <i class="bi bi-box-arrow-right"></i>
                              <span>Log Out</span>
                          </a>
                      </li>
            </ul><!-- End Profile Dropdown Items -->
          @else
              <a class="reg-log-button" href="{{ url('/login') }}" title = "User Registration & Profile Login">Register / Login</a>
              <li class="nav-item dropdown pe-2 nav__dropdown__profile"> 
         @endif
    
        </li><!-- End Profile Nav -->
          <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
          <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    
        </div>
      </header><!-- End Header -->