<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLoginCtlr extends Controller
{
    private $admin;
    private $product ;
    public function __construct()
    {
        $this->admin = new Admin();
        $this->product = new Product() ;
    }

    public function index(Request $request)
    {   if($request->session()->has('admin_id')){
        return view('admin.dashboard')->with([
            'pageTitle' => 'dashboard',
            
        ]);
    }else{
        return view('admin.login');
    }
        
    }


    public function login(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            return view('admin.login');
        } elseif (HttpMethodUtil::isMethodPost()) {
            $phone = $request->get('phone') ?? "";
            $password = $request->get('password') ?? "";
            // dd($this->admin->isPhoneNumberValid($phone));
            if (!$this->admin->isPhoneNumberValid($phone)) {
                return JsonUtil::accessDenied();
            }

            $passwordHash = $this->admin->getPassword($phone);

            if (!password_verify($password, $passwordHash)) {
                return JsonUtil::accessDenied();
            }

            $admin = $this->admin->getAdminByPhone($phone);
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_name', $admin->name);
            $request->session()->put('admin_phone', $admin->phone);
            $request->session()->put('admin_role', $admin->role);

            return JsonUtil::getResponse(true, "Login successfully", JsonUtil::$_STATUS_OK, [
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_phone' => $admin->phone,
                'admin_role' => $admin->role,
            ]);
        }
    }

    public function termsconditions(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            return view('admin.terms-and-conditions')->with([
               
            ]);
        } 
    }

    public function reviewNRatings(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {


            $whereRaw = 'ub.status=?' ;
            $whereParams = ['approved'] ;

            $ongoingData = $this->product->getReviewNRatings($whereRaw,$whereParams, true);

            return view('admin.review-ratings')->with([
                'approvedData' => $ongoingData,
                'sn' => ($ongoingData->currentPage() - 1) * $ongoingData->perPage(),
                
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_id');
        return redirect('admin/login');
    }
}
