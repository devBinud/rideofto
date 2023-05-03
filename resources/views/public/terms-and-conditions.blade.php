@extends('public.layout')
@section('title', 'Terms And Conditions')
@section('custom-css')

@endsection
@section('body')

    <style>
        .termsandc h2{
            font-size:19px;
            font-weight:600;
            color:#ff5f00;
        }
        .termsandc h6 {
            font-weight: 500;
            font-size:18px;
        }
        .termsandc ul li{
            list-style:none;
            margin-left:-20px;
            color:#6c757d;
        }
        @media screen and (max-width:576px){
            .termsandc h2{
            font-size:17px;
        }
        .termsandc p{
            font-size:14px
        }
            .termsandc ul li{
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
            <li class="breadcrumb-item active" aria-current="page" style="color:#ff5f00">Terms and Conditions</li>
        </ol>
    </nav>
            <div class="row">
                <div class="termsandc">
                    <h2>Terms and Conditions : </h2>
                </div>
            </div>
            <div class="row">
                
                <div class="col-12 mt-3">
                    {{-- <h2 class="text-center text-uppercase mb-5">Terms and conditions </h2> --}}
                    <p>These terms and conditions, as may be amended from time to time, apply to all our services directly or indirectly made 
                        available online, through any mobile device, by email or phone. By accessing, browsing, and using our website or any of 
                        our applications through whatever platform (hereafter collectively referred to as the “website”) and/or by completing 
                        a reservation, you acknowledge and agree to have read, understood and agreed to the terms and conditions set out 
                        below (including the privacy statement). 
                    </p>
                    
                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Scope of our Service</span></p>

                    <p>Through the website, we (Rideofto.com. and its affiliate (distribution) partners) provide an online platform through 
                        which bike rental companies can rent out bicycles and through which visitors to the website can book bicycle rentals. By 
                        making a reservation through Rideofto.com, you enter into a direct (legally binding) contractual relationship with the 
                        rental company at which you book. From the point at which you make your reservation, we act solely as an intermediary 
                        between you and the rental company, transmitting the details of your reservation to the relevant rental company and 
                        sending you a confirmation email for and on behalf of the rental company. 
                    </p>
                    <p>When providing our reservation tool, the information that we show is based on the information provided to us by the 
                        rental companies. As such, the rental companies are given access to their dashboard through which they are fully 
                        responsible for updating all rates, availability and other information which is displayed on our website. Although we will 
                        use reasonable skill and care in performing our services we will not verify if, and cannot guarantee that, all information 
                        is accurate, complete or correct, nor can we be held responsible for any errors (including manifest and typographical 
                        errors), any interruptions (whether due to any (temporary and/or partial) breakdown, repair, upgrade or maintenance 
                        of our website or otherwise), inaccurate, misleading or untrue information or non-delivery of information. Each rental 
                        company remains responsible at all times for the accuracy, completeness, and correctness of the (descriptive) 
                        information (including the rates and availability) displayed on our website. Our website does not constitute and should 
                        not be regarded as a recommendation or endorsement.
                    </p>
                    <p>Our reservation tools are made available for personal and non-commercial use only. Therefore, you are not allowed to 
                        re-sell, deep-link, use, copy, monitor (e.g., spider, scrape), display, download or reproduce any content or information, 
                        software, products or services available on our website for any commercial or competitive activity or purpose. 
                    </p>

                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Prices</span></p>

                    <p>All prices on our website are displayed including VAT tax and all other taxes (subject to change of such taxes) unless 
                        stated differently on our website or in the confirmation email. 
                    </p>
                    <p>Obvious errors and mistakes (including misprints) are not binding. </p>

                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Privacy and Cookies</span></p>

                    <p>Rideofto.com respects your privacy. Please take a look at our privacy and cookie policy for further information. </p>

                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Online Payment</span></p>

                    <p>You can pay your bike rental during the reservation process by means of secure online payment (all to the extent offered 
                        and supported by your bank). Payment is safely processed through a third-party payment processor. As a guarantee for 
                        your payment, we will transfer the rental fee (minus a handling fee) to the bank account of the rental company after the 
                        delivery of the rented objects by the company to you. 
                    </p>

                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Cancellation</span></p>

                    <p>By making a reservation, you accept and agree to the relevant cancellation and no-show policy. There is a 100% refund, 
                        if you cancel 24 hours in advance unless otherwise stated during the reservation process. 
                    </p>
                    <p>By making your reservation you agree with any additional (delivery) terms and conditions of the rental company. The 
                        delivery terms and conditions of a rental company can be obtained at the relevant rental company. 
                    </p>

                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Contact</span></p>

                    <p>By completing a booking, you agree to receive e-mails or other electronic messages to inform you about your 
                        reservation, your destination and providing you with certain information and offers (including third party offers to the 
                        extent that you have actively opted in for this information) relevant to your reservation and destination. You also agree 
                        that we may send an e-mail after your rental period inviting you to complete our review form. Please see our privacy 
                        and cookies policy for more information about how we may contact you. 
                    </p>

                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Reviews</span></p>

                    <p>Your completed review may be shown at the relevant rental company information page on our website for the sole 
                        purpose of informing (future) customers of your opinion of the service (level) and quality of the bike rental company. 
                        We can also use (wholly or partly) and place your review (e.g., for marketing, promotion, or improvement of our service) 
                        on our website or such social media platforms, newsletters, special promotions, apps or other channels owned, hosted, 
                        used or controlled by Rideofto.com. We reserve the right to adjust, refuse or remove reviews at our sole discretion. The 
                        review form should be regarded as a survey and does not include any (further commercial) offers, invitations or 
                        incentives whatsoever. 
                    </p>

                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Disclaimer</span></p>

                    <p>Subject to the limitations set out in these terms and conditions and to the extent permitted by law, we shall only be 
                        liable for direct damages actually suffered, paid or incurred by you due to an attributable shortcoming of our obligations 
                        in respect to our services, up to an aggregate amount of the aggregate cost of your reservation as set out in the 
                        confirmation email (whether for one event or series of connected events). 
                    </p>
                    <p>However and to the extent permitted by law, neither we nor any of our officers, directors, employees, representatives, 
                        subsidiaries, affiliated companies, distributors, affiliate (distribution) partners, licensees, agents or others involved in 
                        creating, sponsoring, promoting, or otherwise making available the site and its contents shall be liable for (i) any 
                        punitive, special, indirect or consequential loss or damages, any loss of production, loss of profit, loss of revenue, loss 
                        of contract, loss of or damage to goodwill or reputation, loss of claim, (ii) any inaccuracy relating to the (descriptive) 
                        information (including rates, availability and ratings) of the rental companies and/or their rental objects as made 
                        available on our website, (iii) the services rendered or the products offered by the rental company or other business 
                        partners, (iv) any (direct, indirect, consequential or punitive) damages, losses or costs suffered, incurred or paid by you, 
                        pursuant to, arising out of or in connection with the use, inability to use or delay of our website, or (v) any (personal) 
                        injury, death, property damage, or other (direct, indirect, special, consequential or punitive) damages, losses or costs 
                        suffered, incurred or paid by you, whether due to (legal) acts, errors, breaches, (gross) negligence, wilful misconduct, 
                        omissions, non-performance, misrepresentations, tort or strict liability by or (wholly or partly) attributable to the bike 
                        rental or any of our other business partners (including any of their employees, directors, officers, agents, representatives 
                        or affiliated companies) whose products or service are (directly or indirectly) made available, offered or promoted on or 
                        through the website, including any (partial) cancellation, overbooking, strike, force majeure or any other event beyond 
                        our control. 
                    </p>
                    <p>You agree and acknowledge that the rental company is at all times responsible for the collection, withholding, 
                        remittance and payment of the applicable taxes due on the total amount of the rental fee to the relevant tax authorities. 
                        Rideofto.com is not liable or responsible for the remittance, collection, withholding or payment of the relevant taxes 
                        due on the rental fee to the relevant tax authorities.
                    </p>

                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Intellectual property rights</span></p>

                    <p>Unless stated otherwise, the software required for our services or available on or used by our website and the 
                        intellectual property rights (including the copyrights) of the contents and information of and material on our website 
                        are owned by Rideofto.com, its suppliers or participating rental companies. 
                    </p>
                    <p>Rideofto.com exclusively retains ownership of all rights, title and interest in and to (all intellectual property rights of) 
                        (the look and feel (including infrastructure) of) the website on which the service is made available (including the guest 
                        reviews and translated content) and you are not entitled to copy, scrape, (hyper-/deep)link to, publish, promote, market,integrate, utilize, combine or otherwise use the content (including any translations thereof and the guest reviews) or 
                        our brand without our express written permission.  
                    </p>

                
                    <p class="mt-5"><i class="bi bi-check-circle " style="color:#ff5f00;"></i> <span class="fw-bold px-2">Miscellaneous</span></p>

                    <p>To the extent permitted by law, these terms and conditions and the provision of our services shall be governed by and 
                        construed in accordance with Danish law and any dispute arising out of these general terms and conditions. 
                    </p>
                    <p>The original English version of these terms and conditions is translated into other languages. The translated version is a 
                        courtesy and office translation only and you cannot derive any rights from the translated version. In the event of a 
                        dispute about the contents or interpretation of these terms and conditions or inconsistency or discrepancy between the 
                        English version and any other language version of these terms and conditions, the English language version to the extent 
                        permitted by law shall apply, prevail and be conclusive. The English version is available on our website (by selecting 
                        English language) or shall be sent to you upon your written request. 
                    </p>
                    <p>If any provision of these terms and conditions is or becomes invalid, unenforceable, or non-binding, you shall remain 
                        bound by all other provisions hereof. In such event, such invalid provision shall nonetheless be enforced to the fullest 
                        extent permitted by applicable law, and you will at least agree to accept a similar effect as the invalid, unenforceable or 
                        non-binding provision, given the contents and purpose of these terms and conditions.
                    </p>
                </div>
                
            </div>

        </div>
    </section>
    <!-- Shop Section End -->

    <!-- TERMS AND CONDITION SECTION ENDS -->



@endsection
@section('custom-js')

@endsection
