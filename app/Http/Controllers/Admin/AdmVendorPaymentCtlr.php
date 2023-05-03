<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Vendor;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use App\Utils\RegexUtil;
use Exception;
use Illuminate\Http\Request;

class AdmVendorPaymentCtlr extends Controller
{
    private $vendor ;
    private $admin ;

    public function __construct(Request $request)
    {
        $this->vendor = new Vendor() ;
        $this->admin = new Admin() ;
    }

    public function index(Request $request)
    {
        $action = $request->get('action') ?? '';

        switch ($action) {
            case 'vendor-payment':
                return $this->vendorPayment($request);
                break;

            case 'payment-list':
                return $this->vendorPaymentList($request);
                break;
            
            default:
                return abort(404);
                break;
        }
    }

    public function vendorPayment(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $vendorData = $this->vendor->getVendorListWithPayment();

            // dd($vendorData);
            return view('admin.vendor-payment.vendor-list')->with([
                'currentPage' => 'vendor_payment',
                'city' => $this->admin->getCityAll(),
                'vendorData' => $vendorData,
                'sn' => ($vendorData->currentPage() - 1) * $vendorData->perPage(),
            ]);
        }
    }

    public function vendorPaymentList(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId = $request->get('vendor') ?? '';

            if (empty($vendorId) || !RegexUtil::isNumeric($vendorId) || !$this->vendor->isVendorIdValid($vendorId)) {
                return abort(404) ;
            }

            $paymentData = $this->vendor->getPaymentSettlementList('vendor_id=?',[$vendorId]);

            return view('admin.vendor-payment.payment-list')->with([
                'currentPage' => 'vendor_payment',
                'paymentData' => $paymentData,
                'vendorId' => $vendorId,
                'sn' => ($paymentData->currentPage() - 1) * $paymentData->perPage(),
            ]);

        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }
}
