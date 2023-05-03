@extends('public.layout')
@section('title', 'Booking')
@section('custom-css')
    <style>
        .hire-bike-btn{
        margin-top:-30px;
        background:transparent;
        border:1px solid #f4664f;
        text-align:center;
        padding:8px 16px;
        border-radius:7px;
        color:#f4664f;
        outline:none
    }
    .hire-bike-btn:hover{
        background:#d9472f;
        border:1px solid #f4664f;
        color:#fff;
        transition:0.3s ease
    }
        .px-btn {
            border-radius: 22px;
            color: red !important;
        }

        .px-paginate-container .px-btn.selected {
            background: #f4664f !important;
            color: #fff !important;
        }

        @media (min-width: 1200px) {
            #paginationBox {
                margin-left: 302px !important;
            }
        }

        @media only screen and (max-width: 576px) {
            #paginationBox {
                margin-left: 80px !important;
            }
        }
    </style>
@endsection
@section('body')


    <!-- BOOKING SECTION STARTS -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="search__bikes">
                        <!-- <p>SERACH YOUR BIKES</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar" style="border:1px solid
                    #dfdada;padding:15px;">
                        <form method="GET" id="searchForm">
                            <input type="hidden" name="action" value='bike-store'>
                            <div class="sidebar__color">
                                <div class="section-title">
                                    <h4>PRODUCT FILTERS</h4>
                                    <h6>Bike Type</h6>
                                </div>
                                <div class="size__list color__list">
                                    @foreach ($ProdcutCat as $pc)
                                        <label for="c{{ $pc->id }}">
                                            {{ $pc->product_category }}
                                            <input type="checkbox" class="formCheck" name="catType[]"
                                                value="{{ $pc->category_slug }}" id="c{{ $pc->id }}"
                                                @if (in_array($pc->category_slug, $catSlug)) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                    @endforeach

                                </div>
                            </div>

                            <button type="button" class="btn btn-sm text-white mb-4" data-bs-toggle="modal"
                                data-bs-target="#sizeGuideModal" style="background-color:#f4664f">
                                Size Guide
                            </button>

                            <!-- Size Guide MOdal -->
                            <div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Size Guide</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Hojde(CM)</th>
                                                        <th scope="col">XS-XXL</th>
                                                        <th scope="col">CM/"(City)</th>
                                                        <th scope="col">CM(Racer)</th>
                                                        <th scope="col">Tommer(mtb)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>160-165</td>
                                                        <td>XS/S</td>
                                                        <td>47-51/18.5"-20.5"</td>
                                                        <td>48-52</td>
                                                        <td>14"-15"</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>165-170</td>
                                                        <td>S/M</td>
                                                        <td>51-53/20.5"-21.5"</td>
                                                        <td>52-54</td>
                                                        <td>16"</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td>170-175</td>
                                                        <td>M</td>
                                                        <td>53-55/21.5"-22"</td>
                                                        <td>53-55</td>
                                                        <td>17"</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">3</th>
                                                        <td>175-180</td>
                                                        <td>M/L</td>
                                                        <td>55-57/22"-23"</td>
                                                        <td>54-56</td>
                                                        <td>17"-18"</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">4</th>
                                                        <td>180-185</td>
                                                        <td>L</td>
                                                        <td>57-59/23"-23.5"</td>
                                                        <td>55-58</td>
                                                        <td>17.5"-19"</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">5</th>
                                                        <td>185-190</td>
                                                        <td>L/XL</td>
                                                        <td>59-61/23.5"-24.5"</td>
                                                        <td>58-61</td>
                                                        <td>18"-20"</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">6</th>
                                                        <td>190-195</td>
                                                        <td>XL</td>
                                                        <td>61-62/24.5"-25"</td>
                                                        <td>59-62</td>
                                                        <td>19.5"-21.5"</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">7</th>
                                                        <td>195-200</td>
                                                        <td>XXL</td>
                                                        <td>61-63/25"-25.5"</td>
                                                        <td>61-64</td>
                                                        <td>21.5"-24"</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="sidebar__sizes">
                                <div class="section-title">
                                    <h6>Bike Sizes</h6>
                                </div>
                                <div class="size__list">
                                    <label for="xxs">
                                        13" - 14"
                                        <input type="checkbox" id="xxs">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="xs">
                                        14" - 15"
                                        <input type="checkbox" id="xs">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="xss">
                                        15" - 16"
                                        <input type="checkbox" id="xss">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="s">
                                        16" - 17"
                                        <input type="checkbox" id="s">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="m">
                                        17" - 18"
                                        <input type="checkbox" id="m">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="ml">
                                        18" - 19"
                                        <input type="checkbox" id="ml">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="l">
                                        19" - 20"
                                        <input type="checkbox" id="l">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="xl">
                                        20" - 21"
                                        <input type="checkbox" id="xl">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="xl">
                                        21" - 22"
                                        <input type="checkbox" id="xl">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="booking__list">
                        <div class="booking__list_filter">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>SORT BY :</h4>
                                </div>

                                <div class="col-md-3">
                                    <div class="filter__list">
                                        {{-- <form method="GET" id="searchBikes"> --}}
                                        <input type="hidden" name="action" value="bike-store">
                                        <select class="form-select shadow-none" aria-label="" name="productCatId">
                                            <option value="">New Product</option>
                                            <option value="">Rattings</option>
                                            <option value="">Distance</option>
                                            

                                        </select>
                                        {{-- </form> --}}

                                    </div>
                                </div>
                              
                                
                            </div>
                        </div>
                        <div class="product__listing">
                         
                        <div class="row">
        @if (count($productData) > 0)
        @foreach ($productData as $data)
        <div class="col-md-8 col-lg-6 col-xl-3 mt-3 mt-lg-0">
            <div class="card" style="border-radius: 7px;width:100%;height:100%">
            <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light"
                data-mdb-ripple-color="light" style="height: 57%; width: 95%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;">
                <img src="{{ asset('assets/uploads/product-image/' . $data->product_thumbnail) }}"
                style="border-top-left-radius: 15px; border-top-right-radius: 15px;" class="img-fluid"
                alt="mountain-bike" />
                <a href="#!">
                <div class="mask"></div>
                </a>
            </div>
            <div class="card-body pb-0">
                <div class="d-flex justify-content-between">
                <div>
                    <h6 class="fw-bold">{{ $data->product_name }}</h6>
                    <p class="text-secondary" style="margin-top:-4px">15 Miles away ...</p>
                    <small class="text-danger">
                        @if(!empty($data->discount))

                            @if($data->discount_type == 'flat')

                            Flat {{ $data->discount }} DKK OFF

                            @elseif($data->discount_type == 'percentage')

                            {{ $data->discount }} % OFF

                            @endif

                            @else
                            &nbsp;
                            @endif
                    </small>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-1">
                <a type="button" href="{{ url('product-details', ['slug' => $data->product_slug]) }}" class="hire-bike-btn w-100">Hire Your Bike</a>
                </div>
            
            </div>
            </div>
     </div>
  
        @endforeach
        <div id="paginationBox" class="my-5 ml-5"></div>
            @else
            <div class="col-12 mt-3">
            <h5 class="py-2 text-center text-white" style="background-color:#ff5f00">No Data Found</h5>
            </div>
        @endif
    </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Shop Section End -->

    <!-- BOOKING SECTION ENDS -->



@endsection
@section('custom-js')
    <script src="{{ asset('assets/plugins/px-pagination/px-pagination.js') }}"></script>

    <script>
        $(document).ready(function() {

            // Bike Type Filter
            $('.formCheck').click(function() {
                $('#searchForm').submit();
            });

            // Pagination
            $("#paginationBox").pxpaginate({
                currentpage: {{ $productData->currentPage() }},
                totalPageCount: {{ ceil($productData->total() / $productData->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pagenumber) {
                    var url = "{!! url('bike/bike-store&page=') !!}" + pagenumber;
                    window.location.replace(url);
                },
            });
        });
    </script>
@endsection
