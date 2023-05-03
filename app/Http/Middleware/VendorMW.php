<?php

namespace App\Http\Middleware;

use App\Models\Vendor;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Illuminate\Http\Request;

class VendorMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $vendor = new Vendor() ;

        $vendorId = $request->session()->get('vendor_id', '');
        $isActive = $request->session()->get('is_active', 0);

        $vendorAgreementData = $vendor->getCurrentVendorAgreement($vendorId);

        if ($vendorId == '' || $vendorId == null && $isActive != '1' || $isActive == '0') {

            if (HttpMethodUtil::isMethodGet()) {
                return redirect('vendor/login');
            } else {
                return JsonUtil::accessDenied();
            }
        }

        $request->merge([
            'current_agreement_id' =>  $vendorAgreementData->id ?? '',
            'current_agreement_agreement_name' =>  $vendorAgreementData->agreement_name ?? '',
            'current_agreement_vendor_percentage' =>  $vendorAgreementData->vendor_percentage ?? '',
            'current_agreement_valid_from' =>  $vendorAgreementData->valid_from ?? '',
            'current_agreement_valid_till' =>  $vendorAgreementData->valid_till ?? '',
            'current_agreement_vendor_agree_at' =>  $vendorAgreementData->vendor_agree_at ?? '',
            'current_agreement_status' =>  $vendorAgreementData->status ?? '',
            'current_agreement_agreement_file' =>  $vendorAgreementData->agreement_file ?? '',
        ]);

        return $next($request);
    }
}
