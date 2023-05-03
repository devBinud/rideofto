<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Discount;
use App\Utils\HttpMethodUtil;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Utils\RegexUtil;
use App\Utils\JsonUtil;
use App\Models\Vendor;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PublicCtlr extends Controller
{
    private $product;
    private $vendor;
    private $user;
    private $booking;
    private $discountM;

    public function __construct()
    {
        $this->product = new Product();
        $this->vendor = new Vendor();
        $this->user = new User();
        $this->booking = new Booking();
        $this->discountM = new Discount();
    }

    public function index(Request $request)
    {
        $action = $request->get('action') ?? '';
        switch ($action) {
            // case 'bike-store':
            //     return $this->bikeStore($request);
            //     break;
            case 'book-now':
                return $this->bookNow($request);
                break;
            case 'my-booking':
                return $this->myBooking($request);
                break;
            case 'cencel-booking-by-user':
                return $this->cencelBookingByUser($request);
                break;

            case 'review' :
                return $this->review($request);
                break;
            default:
                return abort(404);
                break;
        }
    }

    public function home(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $paginate = true;
            $whereRaw = ' 1 = ? AND p.product_type_id = ? ';
            $whereParams = [1, 1];

            $productData = $this->product->getAllProductsPublic($whereRaw, $whereParams, $paginate, 4);

            foreach($productData as $key => $val){

                $formatedCatIds = "'0'" ;

                foreach(explode(",",$val->product_category_ids) as $word) {
                    $formatedCatIds .= " OR product_cat_ids LIKE '%$word%' " ;
                }


                $discount = $this->discountM->getDiscount($val->id,$formatedCatIds) ;

                if(!empty($discount) && count($discount) > 0){
                    $productData[$key]->discount_type = $discount[0]->discount_type ;
                    $productData[$key]->discount = $discount[0]->discount ;
                } else {
                    $productData[$key]->discount_type = null ;
                    $productData[$key]->discount = null ;
                }
            }


            $sn = ($productData->currentPage() - 1) * $productData->perPage();
            $vendor = $this->vendor->getAllvendorDetails(4);
            return view('public.home')->with([
                'page' => 'home',
                'sn' => $sn,
                'productData' => $productData,
                'vendor' => $vendor,
            ]);
        } else {
            return abort(404);
        }
    }
    public function bikeStore(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            // dd(1);
            $catSlug = $request->get('catType') ?? [];
            $paginate = true;




            $whereRaw = ' 1 = ? AND p.product_type_id = ? ';
            $whereParams = [1, 1];

            $fil = '';



            if (count($catSlug) > 0) {



                foreach ($catSlug as $cs) {
                    $fil .= "FIND_IN_SET( '$cs',pc.category_slug ) OR ";
                }


                $whereRaw .= " AND (" . substr($fil, 0, -3) . ")";
            }

            // dd($whereRaw) ;

            $productData = $this->product->getAllProductsPublic($whereRaw, $whereParams, $paginate, 20);

            foreach($productData as $key => $val){

                $formatedCatIds = "'0'" ;

                foreach(explode(",",$val->product_category_ids) as $word) {
                    $formatedCatIds .= " OR product_cat_ids LIKE '%$word%' " ;
                }


                $discount = $this->discountM->getDiscount($val->id,$formatedCatIds) ;

                if(!empty($discount) && count($discount) > 0){
                    $productData[$key]->discount_type = $discount[0]->discount_type ;
                    $productData[$key]->discount = $discount[0]->discount ;
                } else {
                    $productData[$key]->discount_type = null ;
                    $productData[$key]->discount = null ;
                }
            }

            // dd($productData);
            $sn = ($productData->currentPage() - 1) * $productData->perPage();
            return view('public.booking')->with([
                'page' => 'bikeStore',
                'sn' => $sn,
                'productData' => $productData,
                'ProdcutCat' => $this->product->getProductCatByProductTypeId(1),
                'catSlug' => $catSlug,
            ]);
        }
    }

    public function productDetails(Request $request, $slug)
    {
        if (HttpMethodUtil::isMethodGet()) {
            //   dd(1);
            if (!$this->product->isProductActiveBySlug($slug)) {
                return abort(404);
            }
            $productData = $this->product->getProductDetailsByProductSlug($slug);
            // dd($productData);
            $vendorId = $productData->vendor_id;
            $productCat = $productData->product_category_ids ?? null;
            $catName = [];
            if ($productCat != null) {
                $c = explode(',', $productCat);
                foreach ($c as $ids) {
                    $cat = $this->product->getCategoryByCategoryId($ids)->product_category;
                    array_push($catName, $cat);
                }
            }

            $formatedCatIds = "'0'" ;

            foreach(explode(",",$productData->product_category_ids) as $word) {
                $formatedCatIds .= " OR product_cat_ids LIKE '%$word%' " ;
            }


            $discount = $this->discountM->getDiscount($productData->id,$formatedCatIds) ;

            if(!empty($discount) && count($discount) > 0){
                $productData->discount_type = $discount[0]->discount_type ;
                $productData->discount = $discount[0]->discount ;
            } else {
                $productData->discount_type = null ;
                $productData->discount = null ;
            }





            $whereRaw = "1=?";
            $whereParams = [1];
            $whereRaw .= ' AND block_date >=CURDATE() order by block_date =?';
            $whereParams = [1, 1];

            $blockDatesData = $this->vendor->getBlockDates($vendorId, $whereRaw,$whereParams);
            // dd($this->vendor->isDateRangeAvailable($vendorId));
            $blockedDates = [];
            foreach($blockDatesData as $b){
                array_push($blockedDates, $b->block_date);
               
            }
            
            if($this->vendor->isDateRangeExistsOnCurrentAndFuture($vendorId)){
                $rangeDates = $this->vendor->getAllFutureAndCurrentDatesFromDateRange($vendorId);
                foreach($rangeDates as $r){
                    array_push($blockedDates,$r->dates);
                }
            }
            // dd($blockedDates);
          $comaSeparatedDates = "'".implode("','", $blockedDates)."'";;
       
            return view('public.product-details')->with([
                'productData' => $productData,
                'vendorTiming' => $this->vendor->vendorTiming($vendorId),
                'productAttrData' => $this->product->getProductDetailsByAttrProductSlug($slug),
                'catNames' => $catName,
                'productId' => $productData->id,
                'productAttribute' => $this->product->getAllProductAttributeByVendorId($vendorId),
                'blockDates' => $comaSeparatedDates,
            ]);
        }
    }

    public function bookNow(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $userId = $request->session()->get('user_id');
            $vendorId = $request->get('vendor_id') ?? '';
            $productId = $request->get('product_id') ?? '';
            $priceingPlanId = $request->get('priceingPlanId') ?? '';
            $pickupdate = $request->get('pickup_date') ?? '';
            // dd($pickupdate);
            $pickuptime = $request->get('pickup_time') ?? '';
            $returndate = $request->get('return_date') ?? '';
            $returntime = $request->get('return_time') ?? '';
            $productAttrId = $request->get('productAttrId') ?? [];
            $attrPrice = $request->get('attrPrice') ?? [];

            if (empty($vendorId) || !RegexUtil::isNumeric($vendorId) || !$this->vendor->isVendorIdValid($vendorId)) {
                return JsonUtil::getResponse(false, "Invalid ID...!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($productId) || !RegexUtil::isNumeric($productId) || !$this->product->isProductIdValid($productId) && $this->product->isProductActive($productId)) {
                return JsonUtil::getResponse(false, "Invalid ID...", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($priceingPlanId) || $priceingPlanId == "") {
                return JsonUtil::getResponse(false, "Please select product price!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($pickupdate)) {
                return JsonUtil::getResponse(false, "Pickup Date is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($pickuptime)) {
                return JsonUtil::getResponse(false, "Pick up Time is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($returndate)) {
                return JsonUtil::getResponse(false, "Return Date is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($returntime)) {
                return JsonUtil::getResponse(false, "Return Time is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $pricePlan = $this->product->getBookingPriceByPricingPlaneId($priceingPlanId);
            $amount = $pricePlan->price;
            // dd($amount);
            $unit = $pricePlan->pricing_plan_unit;
            $currency = $pricePlan->currency;

            $pickupdateTime = date('Y-m-d', strtotime($pickupdate)) . ' ' . date('H:i:s', strtotime($pickuptime));
            $returnDateTime = date('Y-m-d', strtotime($returndate)) . ' ' . date('H:i:s', strtotime($returntime));

            $pickDate = date_create(date('Y-m-d H:i:s', strtotime($pickupdateTime)));
            $dateExpire = date_create(date('Y-m-d H:i:s', strtotime($returnDateTime)));
            $totalDays = date_diff($pickDate, $dateExpire);
            //    dd($totalDays);
            if ($unit == 'hour') {
                $totalHour = round((strtotime($returnDateTime) - strtotime($pickupdateTime)) / 3600, 2);
                // dd($totalHour);
                if ($totalHour < 1) {
                    return JsonUtil::getResponse(false, "Please select a valid date and time!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                $whole = floor($totalHour);
                $fraction = $totalHour - $whole;

                if ($fraction > 0) {
                    $paybleAmount = (round($totalHour, 1) * $amount) + $amount;
                    // dd($paybleAmount);
                } else {
                    $paybleAmount = $totalHour * $amount;
                }
            } elseif ($unit == 'day') {

                // dd($totalDays->format("%d days, %h hours and %i minuts"));
                if ($totalDays->format("%d") == 0) {
                    $paybleAmount = $amount;
                } elseif ($totalDays->format("%d") != 0 && $totalDays->format("%h") == 0) {
                    $paybleAmount = $totalDays->format("%d") * $amount;
                } elseif ($totalDays->format("%d") != 0 && $totalDays->format("%h") != 0) {
                    $paybleAmount = ($totalDays->format("%d") * $amount) + $amount;
                }
                // dd($paybleAmount);
            } elseif ($unit == 'week') {
                $totalWeek = $totalDays->days / 7;
                // dd($totalWeek);
                if ($totalWeek > 1) {
                    $whole = floor($totalWeek);
                    $fraction = $totalWeek - $whole; // .25

                    if ($fraction != 0.0) {
                        $paybleAmount = $amount + $amount;
                    } else {
                        $paybleAmount = $whole * $amount;
                    }
                } else {
                    $paybleAmount = $amount;
                }
            } else {
                $totalMonth = (($totalDays->y) * 12) + ($totalDays->m);
                if ($totalMonth < 1) {
                    $paybleAmount = $amount;
                } elseif ($totalMonth > 1 || $totalMonth == 1 && ($totalDays->d) > 0) {
                    $paybleAmount = ($totalMonth * $amount) + $amount;
                } elseif ($totalMonth > 1 || $totalMonth == 1  && ($totalDays->d) == 0) {
                    $paybleAmount = $totalMonth * $amount;
                }
            }
            // dd($paybleAmount);


            $formatedCatIds = "'0'" ;
            $whereRaw = "p.id=?";
            $whereParam = [$productId];
            $productData = $this->product->getAllProductsPublic($whereRaw,$whereParam,false)[0];
            // dd($productData);
            foreach(explode(",",$productData->product_category_ids) as $word) {
                $formatedCatIds .= " OR product_cat_ids LIKE '%$word%' " ;
            }


            $discount = $this->discountM->getDiscount($productData->id,$formatedCatIds) ;
            $discountAmt = 0 ;

            if(!empty($discount) && count($discount) > 0){
                $productData->discount_type = $discount[0]->discount_type ;
                $productData->discount = $discount[0]->discount ;

                if($productData->discount_type == 'flat'){
                    $paybleAmount =  $paybleAmount-$productData->discount ;

                    $discountAmt  = $productData->discount ;
                } else {
                    $paybleAmount =  $paybleAmount-($paybleAmount*($productData->discount/100)) ;

                    $discountAmt  = $paybleAmount*($productData->discount/100) ;
                }
            } 


            if (!empty($productAttrId)) {
                $withOutAccessoriesPrice = $paybleAmount;

                foreach ($productAttrId as $key => $value) {
                    $paybleAmount = $attrPrice[$key] + $paybleAmount;
                }
            }


            DB::beginTransaction();
            try {

                // User Booking TAble 

                $userBooking = [
                    'vendor_id' => $vendorId,
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'pricing_plan_id' => $priceingPlanId,
                    'booking_price' => $paybleAmount,
                    'discount_amount' => $discountAmt,
                    'currency' => $currency,
                    'pickup_date' => $pickupdate,
                    'return_date' => $returndate,
                    'pickup_time' => $pickuptime,
                    'return_time' => $returntime,
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $bookingId  = $this->booking->userBooking($userBooking);

                // User Booking Details
                $productDetails = [];

                if (!empty($productAttrId)) {

                    $this->booking->userBookingDetails(
                        [
                            'vendor_id' => $vendorId,
                            'user_id' => $userId,
                            'booking_id' => $bookingId,
                            'product_id' => $productId,
                            'product_price' => $withOutAccessoriesPrice,
                            'discount_type' => $productData->discount_type ?? null ,
                            'discount_amount' => $productData->discount ?? 0 ,
                            'final_product_price' => $withOutAccessoriesPrice ,
                            'pricing_plan_id' => $priceingPlanId,
                            'currency' => $currency,
                        ]
                    );

                    foreach ($productAttrId as $key1 => $values) {
                        $data = [
                            'vendor_id' => $vendorId,
                            'user_id' => $userId,
                            'booking_id' => $bookingId,
                            'product_id' => $productAttrId[$key1],
                            'product_price' => $attrPrice[$key1],
                            'discount_type' =>  null ,
                            'discount_amount' =>  0 ,
                            'final_product_price' => $attrPrice[$key1] ,
                            'pricing_plan_id' => $priceingPlanId,
                            'currency' => $currency,
                        ];

                        $this->booking->userBookingDetails($data);
                    }
                } else {
                    $userBookingDetails = [
                        'vendor_id' => $vendorId,
                        'user_id' => $userId,
                        'booking_id' => $bookingId,
                        'product_id' => $productId,
                        'product_price' => $paybleAmount,
                        'discount_type' => $productData->discount_type ?? null ,
                        'discount_amount' => $productData->discount ?? 0 ,
                        'final_product_price' => $paybleAmount ,
                        'pricing_plan_id' => $priceingPlanId,
                        'currency' => $currency,
                    ];
                    $this->booking->userBookingDetails($userBookingDetails);
                }



                DB::commit();
                return JsonUtil::getResponse(true, "Your booking is added successfully !", JsonUtil::$_STATUS_OK, $productId);
            } catch (Exception $e) {
                DB::rollback();
                return JsonUtil::getResponse(false, $e->getMessage(), 500);
            }
        }
    }


    public function myBooking(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $userId = $request->session()->get('user_id');
            $productId = $request->get('productId') ?? null;
            if ($productId != null) {

                if (!RegexUtil::isNumeric($productId) || !$this->product->isProductIdValid($productId)) {
                    return abort(404);
                }
            }

            $type = $request->get('type') ?? '';
            $bookingData = $this->booking->getBookingDataOfUser($userId);
            $orderData = $this->booking->getOrderAndBookingDetailsByProductIdAndUserId($userId, $productId);

            //  if product id is not url just getting the letest booking Id
            if (count($orderData) > 0) {
                $bookingId = $orderData[0]->id;
                $productAccessories = $this->booking->getOnlyProductAccessoriesByBookingId($bookingId, $userId);
            } else {
                $productAccessories = [];
            }

            return view('public.user-booking')->with([
                'userData' => $this->user->getUserByUserId($userId),
                'type' => $type,
                'orderData' => $orderData,
                'data' => $bookingData,
                'productAttr' =>  $productAccessories,
                'sn' => 0,
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {

            $userId = $request->session()->get('user_id');
            // dd($userId);
            $phone = $request->get('phone') ?? '';
            $name = $request->get('fullName') ?? '';
            $image = $request->file('img_file') ?? '';
            $email = $request->get('email') ?? '';
            $address1 = $request->get('address1') ?? '';
            $address2 = $request->get('address2') ?? '';
            $password = $request->get('pwd') ?? '';
            $conPassword = $request->get('pwd') ?? '';


            $currentImage = $this->user->getUserByUserId($userId)->profile_pic;
            $currentPhone = $this->user->getUserByUserId($userId)->phone;
            $currentName = $this->user->getUserByUserId($userId)->name;


            if ($name == "") {
                return JsonUtil::getResponse(false, "Name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($name) > 100) {
                return JsonUtil::getResponse(false, "Name can't be more than 100 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($image == null || empty($image)) {

                if ($currentImage != null) {
                    $imageName = $currentImage;
                } else {
                    return JsonUtil::getResponse(false, "Profile image is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
            } else {
                $ext = $image->getClientOriginalExtension();

                if ($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {

                    return JsonUtil::getResponse(false, "Supported file formats are - png, jpg, jpeg!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif ($image->getSize() > (1024 * 1000 * 2)) {
                    return JsonUtil::getResponse(false, "Maximum supported file size is 2 MB!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                // Upload Profile Img
                $imageName = 'p_' . '_' . time() . '.' . $image->getClientOriginalExtension();

                $upload = $image->storeAs('/profile_picture_user', $imageName);
            }

            if (empty($phone)) {
                return JsonUtil::getResponse(false, "Phone number is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isPhoneNumber($phone)) {
                return JsonUtil::getResponse(false, "Please enter a valid phone numner!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($this->user->isPhoneNumberAvailable($phone)) {
                if (!$this->user->isPhoneNumberAndIdMatch($userId, $phone)) {
                    if ($currentPhone != $phone) {
                        return JsonUtil::getResponse(false, "Phone number is already in use!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }
                }
            }

            if (empty($email)) {
                return JsonUtil::getResponse(false, "email is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isEmail($email)) {
                return JsonUtil::getResponse(false, "Please enter a valid email!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);


            if (!empty($password)) {
                if (!$uppercase || !$lowercase || !$number || !$specialChars) {
                    return JsonUtil::getResponse(false, "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
            }


            try {

                
                if ($currentName != $name) {
                    $request->session()->forget('user_name');
                    session()->put('user_name', $name);
                }

                $this->user->updateUser($userId, [
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'profile_pic' => $imageName,
                    'address01' => $address1,
                    'address02' => $address2,
                    'password' => Hash::make($password),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                return JsonUtil::getResponse(true, "Details saved successfully!", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                JsonUtil::serverError();
            }
        }
    }

    public function cencelBookingByUser(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $bookingId = $request->get('userBookingId') ?? '';
            $reason = $request->get('reason') ?? '';
            // dd($request->session()->get('user_id'));
            if (empty($bookingId) || !RegexUtil::isNumeric($bookingId) || !$this->booking->isBookingIdValid($bookingId)) {
                return JsonUtil::getResponse(false, "Invalid booking Id", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($reason)) {
                return JsonUtil::getResponse(false, "Reason is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($reason) > 100) {
                return JsonUtil::getResponse(false, "Please add your reason under 100 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try {
                $this->booking->updateBooking($bookingId, [
                    'status' => 'canceled',
                    'cencel_reason' => $reason,
                    'cencel_by_user' => $request->session()->get('user_id'),
                    'cenceled_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),

                ]);

                return JsonUtil::getResponse(true, "Cenceled successfully!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        } else {
            JsonUtil::methodNotAllowed();
        }
    }

    public function review(Request $request)
    {
        $bookingId = $request->get('booking_id') ?? '' ;
        $productId = $request->get('product_id') ?? '' ;
        $ratings = $request->get('star') ?? '' ;
        $review = $request->get('review') ?? '' ;

        

        $data = [
            'user_id' => $request->session()->get('user_id'),
            'booking_id' => $bookingId ,
            'product_id' => $productId ,
            'ratings' => $ratings ,
            'review' => $review ,
            'created_at' => now() ,
        ] ;

        // dd($data) ;

        try {
            $this->user->addReview($data) ;

            return JsonUtil::getResponse(true , "Thank you for your review !" ,JsonUtil::$_STATUS_OK) ;
        } catch (Exception $e) {
            return JsonUtil::serverError() ;
        }
    }
}
