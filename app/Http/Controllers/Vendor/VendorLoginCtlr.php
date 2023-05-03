<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vendor;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorLoginCtlr extends Controller
{
    private $vendor;
    private $booking;
    public function __construct()
    {
        $this->vendor = new Vendor();
        $this->booking = new Booking();
    }

    public function index(Request $request)
    {
        $vendorId =  $request->session()->get('vendor_id') ?? '';

        $currentAgreementId = $request->get('current_agreement_id') ?? '' ;

        $agreementData = $this->vendor->getAgreementById($currentAgreementId) ;

        $businessData = $this->vendor->getPaymentSettlementList('vendor_id=?',[$vendorId],false,20,'FORMAT(SUM(total_business),2) as total_business_sum');
        $pendingPaymentData = $this->vendor->getPaymentSettlementList('vendor_id=? AND payment_status=? AND month_end < DATE(NOW())',[$vendorId,'pending'],false,20,'FORMAT(SUM(vendor_amount),2) as pending_vendor_amount_sum');

        

        return view('vendor.dashboard')->with([
            'pageTitle' => 'dashboard',
            'businessData' => $businessData[0]->total_business_sum,
            'pendingPayment' => $pendingPaymentData[0]->pending_vendor_amount_sum,

        ]);
    }
    public function login(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            if ($request->session()->has('vendor_id')) {
                return redirect('vendor/dashboard');
            } else {
                return view('vendor.login');
            }
        } elseif (HttpMethodUtil::isMethodPost()) {

            $phone = $request->get('phone') ?? "";
            // dd($phone);
            $password = $request->get('password') ?? "";
            // dd($this->vendor->isPhoneNumberValid($phone));
            if (!$this->vendor->isPhoneNumberValid($phone)) {
                return JsonUtil::accessDenied();
            }

            $passwordHash = $this->vendor->getPassword($phone);
            // dd($passwordHash);

            if (!password_verify($password, $passwordHash)) {
                return JsonUtil::accessDenied();
            }

            if (!$this->vendor->isVendorIsActive($phone)) {
                return JsonUtil::getResponse(false, "Sorry ! Your Account has been suspended for some reason, please contact admin !", JsonUtil::$_BAD_REQUEST);
            }
            $vendor = $this->vendor->getVendorByPhone($phone);
            // dd($vendor);
            $request->session()->put('vendor_id', $vendor->id);
            $request->session()->put('store_name', $vendor->store_name);
            $request->session()->put('max_delivery_distance', $vendor->max_delivery_distance);
            $request->session()->put('store_phone', $vendor->store_phone);
            $request->session()->put('store_email', $vendor->store_email);
            $request->session()->put('is_active', $vendor->is_active);

            return JsonUtil::getResponse(true, "login successfully!", JsonUtil::$_STATUS_OK, [
                'vendor_id' => $vendor->id,
                'store_name' => $vendor->store_name,
                'vendor_phone' => $vendor->store_phone,
                'vendor_email' => $vendor->store_email,
                'max_delivery_distance' => $vendor->max_delivery_distance,
                'is_active' => $vendor->is_active,
            ]);
        } else {
            JsonUtil::methodNotAllowed();
        }
    }

    public function termsconditions(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $vendorId =  $request->session()->get('vendor_id') ?? '';
            $vendorData = $this->vendor->getVendorDetailsByVendorId($vendorId);

            // dd($vendorData) ;

            return view('vendor.terms-and-conditions')->with([
                'vendorData' => $vendorData,
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {

            $vendorId =  $request->session()->get('vendor_id') ?? '';

            try {
                $this->vendor->editVendor($vendorId, [
                    'tnc_agree_at' => now(),
                ]);

                return JsonUtil::getResponse(true, "Success", JsonUtil::$_STATUS_OK);
                // return JsonUtil::getResponse(true, "")
            } catch (Exception $e) {
                return JsonUtil::serverError();
            }
        }
    }

    public function paymentAggrement(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $vendorId =  $request->session()->get('vendor_id') ?? '';
            $vendorData = $this->vendor->getVendorDetailsByVendorId($vendorId);

            $currentAgreementId = $request->get('current_agreement_id') ?? '' ;
            $currentAgreementName = $request->get('current_agreement_agreement_name') ?? '' ;
            $currentAgreementFile = $request->get('current_agreement_agreement_file') ?? '' ;

            // dd($vendorData) ;

            return view('vendor.payment-aggrement')->with([
                'vendorData' => $vendorData ,
                'agreementData' => [
                    'currentAgreementId' => $currentAgreementId ,
                    'currentAgreementName' => $currentAgreementName ,
                    'currentAgreementFile' => $currentAgreementFile ,
                ]
            ]);
        }
    }

    public function termsconditionsnagreement(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $vendorId =  $request->session()->get('vendor_id') ?? '';
            $vendorData = $this->vendor->getVendorDetailsByVendorId($vendorId);
            $currentAgreementId = $request->get('current_agreement_id') ?? '' ;
            $currentAgreementName = $request->get('current_agreement_agreement_name') ?? '' ;
            $currentAgreementFile = $request->get('current_agreement_agreement_file') ?? '' ;

            return view('vendor.agree-tnc-n-agreement')->with([
                'vendorData' => $vendorData,
                'agreementData' => [
                    'currentAgreementId' => $currentAgreementId ,
                    'currentAgreementName' => $currentAgreementName ,
                    'currentAgreementFile' => $currentAgreementFile ,
                ]
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {

            $vendorId =  $request->session()->get('vendor_id') ?? '';
            $currentAgreementId = $request->get('current_agreement_id') ?? '' ;

           if(empty($currentAgreementId)) {
                return JsonUtil::getResponse(false, "No Agreement Found", JsonUtil::$_UNPROCESSABLE_ENTITY);
           }

            try {

                $this->vendor->updateVendorAgreement($currentAgreementId, [
                    'vendor_agree_at' => now(),
                ]);

                return JsonUtil::getResponse(true, "Success", JsonUtil::$_STATUS_OK);
                // return JsonUtil::getResponse(true, "")
            } catch (Exception $e) {
                return JsonUtil::serverError();
            }
        }
    }

    public function resetPassword(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId =  $request->session()->get('vendor_id') ?? '';
            // dd($vendorId);
            return view('vendor.reset-password')->with([
                'currentPage' => 'resetPassword',
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $vendorId =  $request->session()->get('vendor_id') ?? '';
            $current_password = $request->get('current_password') ?? '';
            $new_password = $request->get('new_password') ?? '';
            $confirm_password = $request->get('confirm_password') ?? '';

            $vendorData = $this->vendor->getVendorDetailsByVendorId($vendorId);
            if ($vendorData == null) {
                return JsonUtil::getResponse(false, "Invalid Vendor !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            // password
            if ($current_password == '') {
                return JsonUtil::getResponse(false, "Current Password is required !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (!password_verify($current_password, $vendorData->password)) {
                return JsonUtil::getResponse(false, "Invalid Current Password !", JsonUtil::$_UNAUTHORIZED);
            }

            if ($new_password == '') {
                return JsonUtil::getResponse(false, "New Password is required !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            // confirm password
            if ($confirm_password == '') {
                return JsonUtil::getResponse(false, " Confirm Password is required !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($new_password != $confirm_password) {
                return JsonUtil::getResponse(false, "Confirmed password does not match with new password !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try {
                $this->vendor->editVendor($vendorId, [
                    'password' => Hash::make($new_password),
                ]);
                return JsonUtil::getResponse(true, "Password has been changed successfully !", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), 500);
                return JsonUtil::serverError();
            }
        } else {
            return abort(404);
        }
    }

    public function logOut(Request $request)
    {
        $request->session()->forget('vendor_id');
        $request->session()->forget('store_phone');
        $request->session()->forget('store_email');
        $request->session()->forget('store_name');
        $request->session()->forget('max_delivery_distance');
        return redirect('vendor/login');
    }
}
