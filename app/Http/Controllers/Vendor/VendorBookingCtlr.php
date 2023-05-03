<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use App\Utils\RegexUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorBookingCtlr extends Controller
{
    private $product;
    private $user;
    private $booking;
    private $vendor ;
    public function __construct()
    {
        $this->product = new Product();
        $this->user = new User();
        $this->booking = new Booking();
        $this->vendor = new Vendor() ;
    }
    public function index(Request $request)
    {
        $action = $request->get('action') ?? '';
        switch ($action) {
            case 'booking-request':
                return $this->bookingRequest($request);
                break;
            case 'get-user-details':
                return $this->getUserProfile($request);
                break;
            case 'approve-reject-booking':
                return $this->approveRejectBooking($request);
                break;
            case 'progress-booking':
                return $this->inProgressBooking($request);
                break;
            case 'booking-history':
                return $this->bookingHistory($request);
                break;
            default:
                return abort(404);
                break;
        }
    }

    public function bookingRequest(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $status = "pending";
            $bookingData = $this->booking->getPendingBookingRequestByVendorId($request->session()->get('vendor_id'), 20, $status);
            // dd($bookingData);
            return view('vendor.booking.booking-request')->with([
                'currentPage' => 'bookingReq',
                'pendingBookingReq' => $bookingData,
                'sn' => ($bookingData->currentPage() - 1) * $bookingData->perPage(),
            ]);
        }
    }

    public function getUserProfile(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $v = null;
            $type = $request->get('type') ?? '';
            switch ($type) {
                case 'viewUser':
                    $userId = $request->get('userId') ?? '';
                    // dd($userId);
                    if (empty($userId) || !RegexUtil::isNumeric($userId) || !$this->user->isUserIdValid($userId)) {
                        return JsonUtil::getResponse(false, "Invalid Id", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }

                    try {
                        $userData = $this->user->getUserByUserId($userId);
                        // dd($userData);
                        $v = view('vendor.booking.partials.user-profile', [
                            'userData' =>  $userData,
                            'type' => 'userProfile',
                        ])->render();
                        return response()->json(['html' => $v], 200);
                    } catch (Exception $e) {
                        JsonUtil::serverError();
                    }

                    break;
                case 'viewBooking':
                    $bookingId = $request->get('bookingId') ?? '';
                    $status = $request->get('status') ?? null;
                    // dd($status);
                    if($status != null){
                        $bookingData = $this->booking->getBookingDataByBookingId($bookingId, $request->session()->get('vendor_id'),null);
                    }else{
                        $bookingData = $this->booking->getBookingDataByBookingId($bookingId, $request->session()->get('vendor_id'), $status);
                    }
                //    dd($bookingData);
                    try {

                        $v = view('vendor.booking.partials.user-details', [
                            'type' => 'bookingData',
                            'bookingData' => $bookingData,
                            'addedAccesories' => $this->booking->getAccessoriesDetailsByBookingIdAndVendorId($bookingId, $request->session()->get('vendor_id')),
                            'sn' => 0,
                        ])->render();
                        return response()->json(['html' => $v], 200);
                    } catch (Exception $e) {
                        JsonUtil::serverError();
                    }
                    break;
                default:
                    break;
            }
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }

    public function approveRejectBooking(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $type = $request->get('type') ?? '';
            // dd($type);
            $bookingId = $request->get('bookingId') ?? '';
            $vendorPercentage = $request->get('current_agreement_vendor_percentage') ?? '' ;

            $sData = null ;


            if ($type == '') {
                return JsonUtil::serverError();
            }

            if (empty($bookingId) || !RegexUtil::isNumeric($bookingId) || !$this->booking->isBookingIdValid($bookingId)) {
                return JsonUtil::getResponse(false, "Invalid booking Id!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($this->booking->isBookingAlreadyCenceledByUser($bookingId)) {
                return JsonUtil::getResponse(false, "Can't be approved! This booking is already cenceled by the user!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $bookingData = $this->booking->getBookingDataByBookingId($bookingId,$request->session()->get('vendor_id', null)) ;


            if ($type == 'reject') {
                $reason = $request->get('reason') ?? '';
                if (empty($reason)) {
                    return JsonUtil::getResponse(false, "Reason is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif (strlen($reason) > 100) {
                    return JsonUtil::getResponse(false, "Please add reason between 100 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                $status = 'rejected';
            } elseif ($type == 'approve') {
                $status = 'approved';
                $reason = null;
            }

            DB::beginTransaction();

            try {
                $this->booking->updateBooking($bookingId, [
                    'reject_reason' => $reason,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => $status,
                    'approve_reject_at' => date('Y-m-d H:i:s'),
                    'approve_rejected_by' => $request->session()->get('vendor_id', null),
                ]);

                if ($type == 'approve') {

                   $sData =  $this->vendor->insertUpdateVendorSettlementAmount($request->session()->get('vendor_id', null),$bookingData->booking_price,$vendorPercentage);

                   if(empty($sData[0]->result)) {
                        DB::rollBack();
                        return JsonUtil::serverError();
                   }
                }

                DB::commit();

                return JsonUtil::getResponse(true, ucfirst($status) . ' successfully!', JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {

                DB::rollBack();
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }

    public function inProgressBooking(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $ongoingData = $this->booking->getPendingBookingRequestByVendorId($request->session()->get('vendor_id'), 20, 'approved');
            return view('vendor.booking.ongoing-booking')->with([
                'currentPage' => 'ongoingBooking',
                'approvedData' => $ongoingData,
                'sn' => ($ongoingData->currentPage() - 1) * $ongoingData->perPage(),
            ]);
        }
    }

    public function bookingHistory(Request $request)
    {
       if(HttpMethodUtil::isMethodGet()){
            $bookingHistory = $this->booking->getBookingHistoryByVendorId($request->session()->get('vendor_id'));
            // dd($bookingHistory);
            return view('vendor.booking.booking-history')->with([
                'currentPage' => 'bookingHistory',
                'bookingHistory' => $bookingHistory,
                'sn' => ($bookingHistory->currentPage() - 1) * $bookingHistory->perPage(),
            ]);
       }
    }

    public function reviewNRatings(Request $request)
    {
        if(HttpMethodUtil::isMethodGet()){

            $ongoingData = $this->product->getReviewByVendorId($request->session()->get('vendor_id'), 20, 'approved');
            return view('vendor.review-ratings')->with([
                'currentPage' => 'ongoingBooking',
                'approvedData' => $ongoingData,
                'sn' => ($ongoingData->currentPage() - 1) * $ongoingData->perPage(),
            ]);

        } else {
            return JsonUtil::methodNotAllowed();
        }
    }
}
