<?php

namespace App\Http\Middleware;

use App\Models\Vendor;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Illuminate\Http\Request;

class VendorTnCMW
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

        $vendorData = $vendor->getCurrentVendorAgreement($vendorId);

        if (empty($vendorData->vendor_agree_at) || $vendorData->vendor_agree_at == null) {

            if (HttpMethodUtil::isMethodGet()) {
                return redirect('vendor/terms-conditions-and-agreement');
            } else {
                return JsonUtil::accessDenied();
            }
        }

        $request->merge([
            'current_agreement_id' =>  $vendorData->id ?? '',
            'current_agreement_agreement_name' =>  $vendorData->agreement_name ?? '',
            'current_agreement_vendor_percentage' =>  $vendorData->vendor_percentage ?? '',
            'current_agreement_valid_from' =>  $vendorData->valid_from ?? '',
            'current_agreement_valid_till' =>  $vendorData->valid_till ?? '',
            'current_agreement_vendor_agree_at' =>  $vendorData->vendor_agree_at ?? '',
            'current_agreement_status' =>  $vendorData->status ?? '',
            'current_agreement_agreement_file' =>  $vendorData->agreement_file ?? '',
        ]);
        

        return $next($request);
    }
}
