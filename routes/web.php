<?php

use App\Http\Controllers\Admin\AdminLoginCtlr;
use App\Http\Controllers\Admin\AdmMasterCtlr;
use App\Http\Controllers\Admin\AdmUserCtlr;
use App\Http\Controllers\Admin\AdmVendorCtlr;
use App\Http\Controllers\Admin\AdmVendorPaymentCtlr;
use App\Http\Controllers\Public\PublicCtlr;
use App\Http\Controllers\Public\PublicLoginCtlr;
use App\Http\Controllers\Public\PublicRegisterCtlr;
use App\Http\Controllers\Vendor\ProductDiscountCtlr;
use App\Http\Controllers\Vendor\VendorBookingCtlr;
use App\Http\Controllers\Vendor\VendorLoginCtlr;
use App\Http\Controllers\Vendor\VendorProductCtlr;
use App\Http\Controllers\Vendor\VendorProfileCtlr;
use App\Utils\SlugGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//------------------------- SLUG GENERATE --------------------
Route::get('generate-slug', function (Request $request) {
    $data = $request->get('data') ?? '';
    return SlugGenerator::generateSlug($data);
});

//-----------------------------Admin------------------------------------------

Route::any('/admin', function () {
    return view('admin.login');
});

Route::any('admin/login', [AdminLoginCtlr::class, 'login']);
Route::middleware(['admin'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::any('dashboard', [AdminLoginCtlr::class, 'index']);

        Route::any('review-ratings', [AdminLoginCtlr::class, 'reviewNRatings']);
        Route::any('terms-conditions', [AdminLoginCtlr::class, 'termsconditions']);

        Route::any('logout', [AdminLoginCtlr::class, 'logOut']);

        Route::any('vendor/', [AdmVendorCtlr::class, 'index']);

        Route::any('vendor-payment', [AdmVendorPaymentCtlr::class, 'index']);

        Route::any('payment-aggrement', [AdmVendorCtlr::class, 'paymentAggrement']);

        Route::any('download-payment-aggrement', [AdmVendorCtlr::class, 'downloadpaymentAggrement']);

        Route::any('user', [AdmUserCtlr::class, 'index']);
        Route::any('master', [AdmMasterCtlr::class, 'index']);
    });
});


/*---------------------------Vendor-----------------------------------*/

Route::any('/vendors', function () {
    return view('vendor.login');
});

Route::any('vendor/login', [VendorLoginCtlr::class, 'login']);
Route::middleware(['vendor'])->group(function () {

    Route::prefix('vendor')->group(function () {

        Route::middleware(['vendor_current_agreement'])->group(function () {

            Route::any('terms-conditions-and-agreement', [VendorLoginCtlr::class, 'termsconditionsnagreement']);

        });
        Route::any('payment-aggrement', [VendorLoginCtlr::class, 'paymentAggrement']);
        Route::any('terms-conditions', [VendorLoginCtlr::class, 'termsconditions']);
        Route::any('change-password', [VendorLoginCtlr::class, 'resetPassword']);
        Route::any('logout', [VendorLoginCtlr::class, 'logOut']);

        Route::middleware(['vendor_T_n_c_agreement'])->group(function () {

            Route::any('dashboard', [VendorLoginCtlr::class, 'index']);

            Route::prefix('product')->group(function () {
                Route::any('/', [VendorProductCtlr::class, 'index']);
            });

            Route::any('discount', [ProductDiscountCtlr::class, 'discount']);
            Route::any('discount/for', [ProductDiscountCtlr::class, 'getDiscountFor']);

            Route::prefix('schedule')->group(function () {
                Route::any('/', [VendorProfileCtlr::class, 'index']);
            });


            Route::prefix('vendor-profile')->group(function () {
                Route::any('/', [VendorProfileCtlr::class, 'index']);
            });

            Route::prefix('booking')->group(function () {
                Route::any('/', [VendorBookingCtlr::class, 'index']);
            });

            Route::any('review-ratings', [VendorBookingCtlr::class, 'reviewNRatings']);
        });
    });
});

//---------------------Public-------------------------------------------

Route::any('/', [PublicCtlr::class, 'home']);

Route::any('login', [PublicLoginCtlr::class, 'login']);
Route::any('/register', [PublicRegisterCtlr::class, 'register']);
Route::get('about-us', function () {
    return view('public.about-us');
});

Route::get('terms-and-conditions', function () {
    return view('public.terms-and-conditions');
});
Route::any('product-details/{product_slug}', [PublicCtlr::class, 'productDetails']);
Route::any('bike/bike-store',[PublicCtlr::class, 'bikeStore']);
Route::middleware(['user'])->group(function () {
    Route::any('logout', [PublicLoginCtlr::class, 'logOut']);



    Route::any('/bike', [PublicCtlr::class, 'index']);
    Route::get('termsandc', function () {
        return view('public.termsandc');
    });

    Route::get('user', function () {
        return view('public.user');
    });

    Route::get('user-profile', function () {
        return view('public.user-profile');
    });

    Route::get('order-confirmation', function () {
        return view('public.order-confirmation');
    });
});
