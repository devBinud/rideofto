@extends('public.layout')
@section('title','About-us')
@section('custom-css')

@endsection
@section('body')

<style>
    .termsandc h6{
     text-transform:uppercase;
     font-weight:600
    }
    .about-us p{
        color:#6c757d!important
    }
    @media screen and (max-width:576px){
        .about-us{
              font-size:14px;
            }
    }
 
</style>

<!-- TERMS AND CONDITION SECTION STARTS -->

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="search__bikes">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="text-secondary">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page" style="color:#ff5f00">About</li>
        </ol>
    </nav>
        <div class="row">
           <div class="about-us">
            <p><span style="color:#ff5f00">Rideofto</span> is the place for bicycle lovers!</p>
            <p>You like to enjoy your travel destination from a bike where you can get around the city freely and quickly. You love nature and will experience it up close from the saddle of a mountain bike or a racing bike. You need a cargo bike that can transport the small family members or items that require more space. Or maybe you need an electrical bike? You may be missing special bicycle parts that you do not want to invest in, but need for a short time.</p>
            <p>Bicycle lovers may need many different cycling experiences but lack just the type of bike that suits the purpose, either because you are on holiday away from home, or because the old bike in the basement does not exactly fit the task.</p>
            <p>Perhaps You want to rent out bikes! But how are the cyclists going to find you? How do people know that you have just the right bike for the right purpose?</p>
            <p>Where do you actually find the right rental place who offers exactly what you are missing?</p>
            <p>The developers behind Rideofto has been in this situation many times, both on vacations and in their daily lives. Therefore, they decided to make life easier for all bicycle lovers!
            We now have the right place that connects both sides of bicycle rental!</p>
            <p>Do you need bikes for You and the whole family? Then use Rideofto and find just the right bike for You.</p>
            <p>Where are you going to Rideofto?</p>
           </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->

<!-- TERMS AND CONDITION SECTION ENDS -->



@endsection
@section('custom-js')

@endsection