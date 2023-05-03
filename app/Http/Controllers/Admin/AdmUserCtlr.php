<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use App\Utils\RegexUtil;
use Exception;
use App\Models\User;
use App\Models\Produc;
use App\Models\Product;

class AdmUserCtlr extends Controller
{

    private $user;
    private $product;
    private $booking;

    public function __construct()
    {
        $this->user = new User();
        $this->product = new Product();
        $this->booking = new Booking();
    }

    public function index(Request $request)
    {
        $action = $request->get('action') ?? '';
        switch ($action) {
            case 'user-list':
                return $this->userList($request);
                break;
            case 'user-details':
                return $this->userDetails($request);
                break;
            case 'user-product-details':
                return $this->userProductDetails($request);
                break;
            case 'active-user':
                return $this->activeUser($request);
                break;
            case 'booking-list':
                return $this->bookingList($request);
                break;
            case 'view-booking-details':
                return $this->bookingDetails($request);
                break;
            default:
                return abort(404);
                break;
        }
    }

    public function userList(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            // dd(1);
            $paginate = true;
            $whereRaw = "1=?";
            $whereParams = [1];
            $userData = $this->user->getAllUser($whereRaw, $whereParams, $paginate, 20);
            return view('admin.user.user-list')->with([
                'currentPage' => 'userlist',
                'userData' => $userData,
                'sn' => ($userData->currentPage() - 1) * $userData->perPage(),
            ]);
        } else {
            return abort(404);
        }
    }

    public function userDetails(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $paginate = true;
            $whereRaw = "1=?";
            $whereParams = [1];
            $userId = $request->get('id') ?? '';
            $userBookingData = $this->booking->getUserBookingDetailsByUserId($userId);
            // dd($userBookingData);
            $userAllBookingData = $this->booking->getUserAllBookingDetailsByUserId($userId, $whereRaw, $whereParams, $paginate, 20);
            return view('admin.user.view-user-details')->with([
                'currentPage' => 'userdetails',
                'userData' => $userBookingData,
                'allBookingData' => $userAllBookingData,
                'sn' => ($userAllBookingData->currentPage() - 1) * $userAllBookingData->perPage(),
                'id' => $userId,
            ]);
        } else {
            return abort(404);
        }
    }


    public function userProductDetails(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $productId = $request->get('id') ?? '';
            if (empty($productId) || !RegexUtil::isNumeric($productId)) {
                return JsonUtil::getResponse(false,"Invalid Id!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            $v = view('admin.user.partials.view-product-details', [
                'productDetails' => $this->booking->getUserBookingProductDetailsByProductId($productId),
            ])->render();
            return response()->json(['html' => $v], 200);
        } else {
            return abort(404);
        }
    }

    // Active User
    public function activeUser(Request $request)
    {
        $userId = $request->get('user_id') ?? '';
        $isActive = $request->get('isActive') ?? '';
        if (empty($userId) || !$this->user->isUserIdValid($userId)) {
            return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
        }
        try {
            if ($isActive == '1') {
                $status = 'activated';
            } else {
                $status = 'deactivated';
            }
            $this->user->updateUser($userId, [
                'is_active' => $isActive,
            ]);
            return JsonUtil::getResponse(true, "User " . $status . " successfully !", JsonUtil::$_STATUS_OK);
        } catch (Exception $e) {
            return JsonUtil::getResponse(false, $e->getMessage(), 500);
            return JsonUtil::serverError();
        }
    }



    // Booking List
    public function bookingList(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $paginate = true;
            $whereRaw = "1=?";
            $whereParams = [1];
            $bookingList = $this->booking->getUserAllBookingList($whereRaw, $whereParams, $paginate, 20);
            return view('admin.booking.booking-list')->with([
                'currentPage' => 'bookinglist',
                'bookinglist' => $bookingList,
                'sn' => ($bookingList->currentPage() - 1) * $bookingList->perPage(),
            ]);
        } else {
            return abort(404);
        }
    }

    public function bookingDetails(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $productId = $request->get('product_id') ?? '';
            if (empty($productId) || !RegexUtil::isNumeric($productId) || !$this->product->isProductIdValid($productId)) {
                return abort(404);
            }
           
            
            return view('admin.booking.view-booking-details')->with([
                'currentPage' => 'bookingDetails',
                'bookingDetailsData' => $this->booking->getBookingDetailsById($productId),
            ]);
        } else {
            return abort(404);
        }
    }
}
