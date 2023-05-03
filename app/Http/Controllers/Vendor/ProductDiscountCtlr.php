<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Vendor;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use App\Utils\RegexUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductDiscountCtlr extends Controller
{
    private $product;
    private $vendor;
    private $unit;
    private $booking;
    private $discount;

    public function __construct()
    {
        $this->product = new Product();
        $this->vendor = new Vendor();
        $this->unit = new Unit();
        $this->booking = new Booking();
        $this->discount = new Discount();

    }

    public function discount(Request $request)
    {
        $action = $request->get('action') ?? '';
        switch ($action) {
            case 'add-discount':
                return $this->addDiscount($request);
                break;
            case 'edit-discount':
                return $this->editDiscount($request);
                break;
            case 'view-discount':
                return $this->viewDiscount($request);
                break;
            case 'delete-discount':
                return $this->deleteDiscount($request);
                break;
            case 'active-discount':
                return $this->activeDiscount($request);
                break;
           
            default:
                return abort(404);
                break;
        }
    }

    public function getDiscountFor(Request $request)
    {
        $type = $request->get('for') ?? '';
        // dd($type);
        $data = null;
        $whereRaw = "p.vendor_id=? or p.is_active = '0'";
        $whereParam = [$request->session()->get('vendor_id')];
        $productData = $this->product->getAllProductsPublic($whereRaw, $whereParam,false);
        switch ($type) {
            case '1':
                $data = $this->product->getAllProductCategory($whereRaw = '1=?', $whereParams = [1]);
                break;
            case '2':
                $data = $productData;
                break;
            default:
                $data = null;
                break;
        }

        return JsonUtil::getResponse(true, "Data has been fetched", JsonUtil::$_STATUS_OK, $data);
    }

    public function addDiscount(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $discountList = $this->discount->getDiscountList($request->session()->get('vendor_id'), 20);
            return view('vendor.discount.add-discount')->with([
                'currentPage' => 'discount',
                'discountList' => $discountList,
                'sn' => ($discountList->currentPage() - 1) * $discountList->perPage(),

            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $vendorId = $request->session()->get('vendor_id') ?? '';
            $discount_type = $request->get('discount_type') ?? '';
            $selectDiscountFor = $request->get('selectDiscountFor') ?? '';
            $product_or_categoryIds = $request->get('product_or_categoryIds') ?? [];
            $discount_amount = $request->get('discount_amount') ?? '';
            $start_date = $request->get('start_date') ?? '';
            $end_date = $request->get('end_date') ?? '';

            if(empty($discount_type)){
                return JsonUtil::getResponse(false,"Please select discount type!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if(empty($selectDiscountFor)){
                return JsonUtil::getResponse(false,"Please select category Or product",JsonUtil::$_UNPROCESSABLE_ENTITY);

            }

            if (count($product_or_categoryIds) > 0) {
                $catProductIds =  implode(",", $product_or_categoryIds);
            } else {
                return JsonUtil::getResponse(false, "Please select options !", JsonUtil::$_BAD_REQUEST);
            }

            if(empty($discount_amount)){
                return JsonUtil::getResponse(false,"Discounted amount is required!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }elseif(!RegexUtil::isFloat($discount_amount)){
                return JsonUtil::getResponse(false,"Discounted amount accepts only numaric!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if(empty($start_date)){
                return JsonUtil::getResponse(false,"Start date is required!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            // dd($catProductIds);
            $vlaues = [
                'vendor_id' => $vendorId,
                'discount_type' => $discount_type,
                'discount' => $discount_amount,
                'discount_product_or_category' => $selectDiscountFor,
                'starting_from' => $start_date,
                'valid_till' => $end_date,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            try {
                switch ($selectDiscountFor) {
                    case '1':
                        $vlaues['product_cat_ids'] = $catProductIds ?? null;
                        break;
                    case '2':
                        $vlaues['product_ids'] = $catProductIds ?? null;
                        break;
                }
                $this->discount->insertDiscount($vlaues);
               
                return JsonUtil::getResponse(true, "Discount has been created successfully", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function editDiscount(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $discountId = $request->get('id') ?? '';
            if (empty($discountId) || !$this->discount->isDiscountIdValid($discountId)) {
                return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $discountData = $this->discount->getDiscountById($discountId);

            $discountProductOrCategory = [];
            $whereRaw = "p.vendor_id=? or p.is_active = '0'";
            $whereParam = [$request->session()->get('vendor_id')];
            switch ($discountData->discount_product_or_category) {
                case 'Category':
                    $discountProductOrCategory = $this->product->getProductCategories(0);
                    break;
                case 'Product':
                    $discountProductOrCategory = $this->product->getAllProductsPublic($whereRaw, $whereParam,false);
                    break;
                default:
                    $discountProductOrCategory = null;
                    break;
            }

            return view('vendor.discount.edit-discount')->with([
                'discountData' => $discountData,
                'discountProductOrCategory' => $discountProductOrCategory,
                'currentPage' => 'editdiscount',
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $discountId = $request->get('id') ?? '';
            if (empty($discountId) || !$this->discount->isDiscountIdValid($discountId)) {
                return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            $vendorId = $request->session()->get('vendor_id') ?? '';
            $discount_type = $request->get('discount_type') ?? '';
   
            $productorcategory = $request->get('productorcategory') ?? '';
            $product_or_categoryIds = $request->get('product_or_categoryIds') ?? [];
            // dd($product_or_categoryIds);
            $discount_amount = $request->get('discount_amount') ?? '';
            $start_date = $request->get('start_date') ?? '';
            $end_date = $request->get('end_date') ?? '';

            if(empty($discount_type)){
                return JsonUtil::getResponse(false,"Please select discount type!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

           

            if (count($product_or_categoryIds) > 0) {
                $catProductIds =  implode(",", $product_or_categoryIds);
            } else {
                return JsonUtil::getResponse(false, "Please select options !", JsonUtil::$_BAD_REQUEST);
            }

            if(empty($discount_amount)){
                return JsonUtil::getResponse(false,"Discounted amount is required!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }elseif(!RegexUtil::isFloat($discount_amount)){
                return JsonUtil::getResponse(false,"Discounted amount accepts only numaric!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if(empty($start_date)){
                return JsonUtil::getResponse(false,"Start date is required!",JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $vlaues = [
                'vendor_id' => $vendorId,
                'discount_type' => $discount_type,
                'discount' => $discount_amount,
                'discount_product_or_category' => $productorcategory,
                'starting_from' => $start_date,
                'valid_till' => $end_date,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            try {
                switch ($productorcategory) {
                    case '1':
                        $vlaues['product_cat_ids'] = $catProductIds ?? null;
                        break;
                    case '2':
                        $vlaues['product_ids'] = $catProductIds ?? null;
                        break;
                }
                $this->discount->discountUpdate($discountId, $vlaues);
                return JsonUtil::getResponse(true, "Discount has been Updated successfully", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::serverError();
            }
        }
    }

    public function viewDiscount(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $discountId = $request->get('discountId') ?? '';
            if (empty($discountId) || !$this->discount->isDiscountIdValid($discountId)) {
                return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            $v = null;
            $data = [];
            $pData = [];

            try {
                // Category Name
                $discountData = $this->discount->getDiscountById($discountId);
                $catId = $discountData->product_cat_ids;
                // dd($catId);
                if ($catId != null) {
                    $catArray = explode(',', $catId);
                    // dd($catArray);
                    if (count($catArray) > 1) {
                        foreach ($catArray as $c) {
                            $catNames = $this->product->getCategoryByCategoryId($c)->product_category;
                           
                            array_push($data, $catNames);
                        }
                        // dd($data);
                        $catNames = implode(',', $data);
                      
                    } else {
                        $catNames = $this->product->getCategoryByCategoryId($catId)->product_category;
                    }
                } else {
                    $catNames = 'N/A';
                }

                // Product Name
                $discountData = $this->discount->getDiscountById($discountId);
                $productId = $discountData->product_ids;
                if ($productId != null) {
                    $productArray = explode(',', $productId);
                    if (count($productArray) > 1) {
                        foreach ($productArray as $p) {
                            $productNames = $this->product->getproductByproductId($request->session()->get('vendor_id'), $p)->product_name;

                            array_push($pData, $productNames);
                        }
                        $productNames = implode(',', $pData);
                    } else {
                        $productNames = $this->product->getProductByProductId($request->session()->get('vendor_id'), $productId)->product_name;
                    }
                } else {
                    $productNames = 'N/A';
                }

                // dd($catNames);
                $v = view('vendor.discount.partials.view-discount', [
                    'discountData' => $this->discount->getDiscountById($discountId),
                    'categoryNames' => $catNames ?? 'N/A',
                    'productName' => $productNames ?? 'N/A',

                ])->render();
                return response()->json(['html' => $v], 200);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false,$e->getMessage(),JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        } else {
            return abort(404);
        }
    }

    public function deleteDiscount(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $discountId = $request->get('discountId') ?? '';
            if (empty($discountId) || !$this->discount->isDiscountIdValid($discountId)) {
                return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            try {
                $this->discount->deleteDiscount($discountId);
                return JsonUtil::getResponse(true, "Discount deleted succssfully!", 200);
            } catch (Exception $e) {
                return JsonUtil::serverError();
            }
        } else {
            return abort(404);
        }
    }

    public function activeDiscount(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $discountId = $request->get('discount_id') ?? '';
            $isActive = $request->get('isActive') ?? '';
            if (empty($discountId) || !$this->discount->isDiscountIdValid($discountId)) {
                return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            try {
                $this->discount->discountUpdate($discountId, [
                    'is_active' =>  $isActive,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                $activeOrDeactive = $isActive == '1' ? 'activated' : 'deactivated';
                return JsonUtil::getResponse(true, "Discount " . $activeOrDeactive .  " successfully !", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                // return JsonUtil::getResponse(false, $e->getMessage(), 500);
                return JsonUtil::serverError();
            }
        }
    }
}
