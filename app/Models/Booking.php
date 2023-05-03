<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory;
    protected $userbooking = "user_booking";
    protected $userbookingdetails = "user_booking_details";
    protected $discount = "vendor_product_discount";

    // Check-----------------------

    public function isProductAlreadyBooked($productId)
    {
        return DB::table($this->userbookingdetails)->where('product_id', $productId)->count() > 0;
    }

    public function isBookingAlreadyCenceledByUser($bookingId)
    {
        return DB::table($this->userbooking)
            ->where('id', $bookingId)
            ->where('status', 'canceled')
            ->count() > 0;
    }

    public function isBookingIdValid($bookingId)
    {
        return DB::table($this->userbooking)->where('id', $bookingId)->count() > 0;
    }


    // Read---------------------------------

    public function getUserBookingDetailsByUserId($userId)
    {
        return DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.*',
                'ub.id',
                'ub.user_id',
                'user.name',
                'user.profile_pic',
                'user.phone',
                'user.email',
                'user.address01',
                'user.address02',
                'user.is_active'

            )
            ->leftJoin('user', 'user.id', 'ub.user_id')
            ->where('ub.user_id', $userId)
            ->orderByDesc('ub.user_id')
            ->first();
    }

    public function getUserAllBookingDetailsByUserId($userId, $whereRaw = '1=?', $whereParams = [1], $paginate = true, $perPage = 20)
    {
        $querry = DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.*',
                'ubd.product_id',
                'p.product_name',
                'p.product_thumbnail',
                'ubd.product_price',
                'vendor.store_name'

            )
            ->leftJoin('user_booking_details as ubd', 'ubd.booking_id', 'ub.id')
            ->leftJoin('product as p', 'p.id', 'ubd.product_id')
            ->leftJoin('vendor', 'vendor.id', 'ub.vendor_id')
            ->where('ub.user_id', $userId)
            ->whereRaw($whereRaw, $whereParams)
            ->orderByDesc('ub.id');
        if ($paginate) {
            return $querry->paginate($perPage);
        } else {
            return $querry->get();
        }
    }

    public function getUserBookingProductDetailsByProductId($productId)
    {
        return DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.*',
                'ub.id',
                'ubd.product_id',
                'ub.user_id',
                'p.product_name',
                'p.product_thumbnail',
                'ubd.product_price',
                'ub.currency',
                'p.product_description',
                'vendor.store_name'

            )
            ->leftJoin('user_booking_details as ubd', 'ubd.booking_id', 'ub.id')
            ->leftJoin('product as p', 'p.id', 'ubd.product_id')
            ->leftJoin('vendor', 'vendor.id', 'ub.vendor_id')
            ->where('ub.id', $productId)
            ->first();
    }

    public function getUserAllBookingList($whereRaw = '1=?', $whereParams = [1], $paginate = true, $perPage = 20)
    {
        $querry = DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.*',
                'ubd.product_id',
                'p.product_name',
                'p.product_thumbnail',
                'ubd.product_price',
                'vendor.store_name',
                'user.name',
                'user.phone',
                'user.email',

            )
            ->leftJoin('user_booking_details as ubd', 'ubd.booking_id', 'ub.id')
            ->leftJoin('product as p', 'p.id', 'ubd.product_id')
            ->leftJoin('vendor', 'vendor.id', 'ub.vendor_id')
            ->leftJoin('user', 'user.id', 'ub.user_id')
            ->whereRaw($whereRaw, $whereParams)
            ->orderByDesc('ub.id');
        if ($paginate) {
            return $querry->paginate($perPage);
        } else {
            return $querry->get();
        }
    }

    public function getBookingDetailsById($productId)
    {
        return DB::table($this->userbookingdetails . ' as ubd')
            ->select(
                'ubd.*',
                'p.product_name',
                'p.product_thumbnail',
                'p.product_description',
                'vendor.store_name',
                'vendor.store_phone',
                'vendor.address',
                'vendor.store_email',
                'vendor.postal_code',
                'vendor.address',
                'user.name',
                'user.phone',
                'user.email',
                'user.address01',
                'user.address02',
                'ub.pickup_date',
                'ub.pickup_time',
                'ub.return_date',
                'ub.return_time',
                'ub.status',

            )
            ->leftJoin('user_booking as ub', 'ub.id', 'ubd.booking_id')
            ->leftJoin('product as p', 'p.id', 'ubd.product_id')
            ->leftJoin('vendor', 'vendor.id', 'ubd.vendor_id')
            ->leftJoin('user', 'user.id', 'ubd.user_id')
            ->where('ubd.product_id', $productId)
            ->first();
    }

    public function getBookingHistoryByVendorId($vendorId, $perPage = 20)
    {
        return DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.id',
                'ub.vendor_id',
                'v.store_name',
                'v.address',
                'ub.user_id',
                'ub.product_id',
                'pd.product_name',
                'pd.product_images',
                'u.id as userId',
                'u.name as username',
                'u.phone as userPhone',
                'u.email as userEmail',
                'u.address01 as userAddress',
                'u.profile_pic as userProfilePic',
                'ub.pricing_plan_id',
                'p.pricing_plan_unit',
                'ub.booking_price',
                'ub.currency',
                'ub.pickup_date',
                'ub.pickup_time',
                'ub.return_date',
                'ub.return_time',
                'ub.status',
                'ub.cencel_reason',
                'ub.created_at',

            )
            ->leftJoin('vendor as v', 'v.id', '=', 'ub.vendor_id')
            ->leftJoin('user as u', 'u.id', '=', 'ub.user_id')
            ->leftJoin('vendor_product_pricing as p', 'p.id', '=', 'ub.pricing_plan_id')
            ->leftJoin('product as pd', 'pd.id', '=', 'ub.product_id')
            ->where('v.id', $vendorId)
            ->whereIn('ub.status', ['approved', 'rejected', 'canceled'])
            ->orderByDesc('ub.id')->paginate($perPage);
    }

    public function getPendingBookingRequestByVendorId($vendorId, $perPage, $status = null)
    {
        $querry = DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.id',
                'ub.vendor_id',
                'v.store_name',
                'v.address',
                'ub.user_id',
                'ub.product_id',
                'pd.product_name',
                'pd.product_images',
                'u.id as userId',
                'u.name as username',
                'u.phone as userPhone',
                'u.email as userEmail',
                'u.address01 as userAddress',
                'u.profile_pic as userProfilePic',
                'ub.pricing_plan_id',
                'p.pricing_plan_unit',
                'ub.booking_price',
                'ub.currency',
                'ub.pickup_date',
                'ub.pickup_time',
                'ub.return_date',
                'ub.return_time',
                'ub.status',
                'ub.created_at',

            )
            ->leftJoin('vendor as v', 'v.id', '=', 'ub.vendor_id')
            ->leftJoin('user as u', 'u.id', '=', 'ub.user_id')
            ->leftJoin('vendor_product_pricing as p', 'p.id', '=', 'ub.pricing_plan_id')
            ->leftJoin('product as pd', 'pd.id', '=', 'ub.product_id')

            ->where('v.id', $vendorId);


        if ($status == null) {
            return $querry->orderByDesc('ub.id')->paginate($perPage);
        } else {
            return $querry->where('ub.status', $status)->orderByDesc('ub.id')->paginate($perPage);
        }
    }

    public function getBookingDataByBookingId($bookingId, $vendorId, $status = null)
    {
        $q = DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.id',
                'ub.vendor_id',
                'v.store_name',
                'v.address',
                'ub.user_id',
                'ub.product_id',
                'pd.product_name',
                'pd.product_images',
                'u.name as userName',
                'u.phone as userPhone',
                'u.email as userEmail',
                'ub.pricing_plan_id',
                'p.pricing_plan_unit',
                'p.price as orginalProductPrice',
                'p.currency as originalCurrency',
                'ub.booking_price',
                'ub.discount_amount',
                'ub.final_booking_price',
                'ub.currency as paidCurrency',
                'ub.pickup_date',
                'ub.pickup_time',
                'ub.return_date',
                'ub.return_time',
                'ub.status',
                'ub.cencel_reason',
                'ub.reject_reason',
                'ub.created_at',
            )
            ->leftJoin('vendor as v', 'v.id', '=', 'ub.vendor_id')
            ->leftJoin('user as u', 'u.id', '=', 'ub.user_id')
            ->leftJoin('vendor_product_pricing as p', 'p.id', '=', 'ub.pricing_plan_id')
            ->leftJoin('product as pd', 'pd.id', '=', 'ub.product_id')
            ->where([['ub.id', $bookingId], ['ub.vendor_id', $vendorId]]);
        if ($status == null) {
            return $q->first();
        } else {
            return $q->where('ub.status', $status)->first();
        }
    }

    public function getAccessoriesDetailsByBookingIdAndVendorId($bookingId, $vendorId)
    {
        return DB::table($this->userbookingdetails . ' as ubd')
            ->select(
                'ubd.id',
                'ubd.product_id',
                'p.product_name',
                'ubd.product_price',
                'ubd.currency',
            )
            ->leftJoin('product as p', 'p.id', '=', 'ubd.product_id')
            ->leftJoin('user_booking as u', 'u.id', '=', 'ubd.booking_id')
            ->where([['ubd.booking_id', $bookingId], ['ubd.vendor_id', $vendorId]])
            ->where('p.product_type_id', 2)
            ->get();
    }

    public function getBookingDataOfUser($userId)
    {
        return DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.id',
                'ub.vendor_id',
                'v.store_name',
                'v.address',
                'ub.user_id',
                'ub.product_id',
                'pd.product_name',
                'u.name',
                'ub.pricing_plan_id',
                'p.pricing_plan_unit',
                'ub.booking_price',
                'ub.currency',
                'ub.pickup_date',
                'ub.pickup_time',
                'ub.return_date',
                'ub.return_time',
                'ub.status',
                'ub.created_at',
                'ub.reject_reason',
                'ub.cencel_reason',
                'ur.ratings' ,
                'ur.review' ,
                'ur.id as review_id'
            )
            ->leftJoin('vendor as v', 'v.id', '=', 'ub.vendor_id')
            ->leftJoin('user as u', 'u.id', '=', 'ub.user_id')
            ->leftJoin('vendor_product_pricing as p', 'p.id', '=', 'ub.pricing_plan_id')
            ->leftJoin('product as pd', 'pd.id', '=', 'ub.product_id')
            ->leftJoin('user_review as ur', 'ub.id', '=', 'ur.booking_id')
            ->where('ub.user_id', $userId)
            ->orderByDesc('ub.id')
            ->get();
    }

    public function getOrderAndBookingDetailsByProductIdAndUserId($userId, $productId = null)
    {
        $querry =  DB::table($this->userbooking . ' as ub')
            ->select(
                'ub.id',
                'ub.vendor_id',
                'v.store_name',
                'v.address',
                'ub.user_id',
                'ub.product_id',
                'pd.product_name',
                'pd.product_images',
                'u.name',
                'ub.pricing_plan_id',
                'p.pricing_plan_unit',
                'ub.booking_price',
                'ub.currency',
                'ub.pickup_date',
                'ub.pickup_time',
                'ub.return_date',
                'ub.return_time',
                'ub.status',
                'ub.created_at',
            )
            ->leftJoin('vendor as v', 'v.id', '=', 'ub.vendor_id')
            ->leftJoin('user as u', 'u.id', '=', 'ub.user_id')
            ->leftJoin('vendor_product_pricing as p', 'p.id', '=', 'ub.pricing_plan_id')
            ->leftJoin('product as pd', 'pd.id', '=', 'ub.product_id')
            ->where('ub.user_id', $userId);
        if ($productId != null) {
            return $querry->where('ub.product_id', $productId)->orderByDesc('ub.id')
                ->get();
        } else {
            return $querry->orderByDesc('ub.id')->get();
        }
    }

    public function getOnlyProductAccessoriesByBookingId($bookingId, $userId)
    {
        return DB::table($this->userbookingdetails . ' as ub')
            ->select('p.product_name', 'pprize.price', 'pprize.currency')
            ->leftJoin('product as p', 'p.id', '=', 'ub.product_id')
            ->leftJoin('vendor_product_pricing as pprize', 'pprize.id', '=', 'p.id')
            ->leftJoin('master_product_type as pt', 'pt.id', '=', 'p.product_type_id')
            ->where([['ub.booking_id', $bookingId], ['ub.user_id', $userId], ['pt.id', 2]])
            ->get();
    }

    // Add Update-----------------------------

    public function userBooking(array $values)
    {
        return DB::table($this->userbooking)->insertGetId($values);
    }

    public function updateBooking($bookingId, $val)
    {
        return DB::table($this->userbooking)->where('id', $bookingId)->update($val);
    }

    public function userBookingDetails(array $values)
    {
        return DB::table($this->userbookingdetails)->insertGetId($values);
    }

}
