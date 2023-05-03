<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Vendor;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use App\Utils\RegexUtil;
use Exception;
use App\Utils\Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;

class AdmVendorCtlr extends Controller
{
    private $vendor;
    private $admin;
    private $product;
    private $unit;
    public function __construct()
    {
        $this->vendor = new Vendor();
        $this->admin = new Admin();
        $this->product = new Product();
        $this->unit = new Unit();   
    }

   
    
    public function index(Request $request)
    {
        $action = $request->get('action') ?? '';

        switch ($action) {
            case 'vendor-list':
                return $this->vendorList($request);
                break;
            case 'add-vendor':
                return $this->addVendor($request);
                break;
            case 'edit-vendor':
                return $this->editVendor($request);
                break;
            case 'delete-vendor':
                return $this->deleteVendor($request);
                break;
            case 'vendor-details-by-id':
                return $this->getVendorDetailsById($request);
                break;
            case 'vendor-change-password':
                return $this->vendorResetPassword($request);
                break;
            case 'active-deactive-vendor':
                return $this->vendorActiveDeactive($request);
                break;

            case 'vendor-details':
                return $this->vendorDetails($request);
                break;
            case 'vendor-item-lists':
                return $this->vendorItemLists($request);
                break;
            case 'vendor-add-item':

                $item = $request->get('item') ?? 'Cycle';

                if ($item == 'Accessories') {
                    return $this->vendorAddAccessories($request);
                } else {
                    return $this->vendorAddCycle($request);
                }

                break;
            case 'active-deactive-product':
                return $this->activeDeactiveProduct($request);
                break;
            case 'vendor-orders':
                return $this->vendorOrders($request);
                break;
            case 'vendor-review-ratings':
                return $this->vendorRatings($request);
                break;
            default:
                return abort(404);
                break;
        }
    }

    public function vendorList(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $whereRaw = '1=?';
            $whereParam = [1];
            $orderByRaw = 'vendor.id DESC';
            $paginate = true;
            $perPage = 10;


            $vendorData = $this->vendor->getVendors($whereRaw, $whereParam, $orderByRaw, $paginate, $perPage);
            return view('admin.vendor.vendor-list')->with([
                'currentPage' => 'vendor',
                'city' => $this->admin->getCityAll(),
                'vendorData' => $vendorData,
                'sn' => ($vendorData->currentPage() - 1) * $vendorData->perPage(),
            ]);
        }
    }
    

    public function addVendor(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $storeName = $request->get('sName') ?? '';
            $phone = $request->get('phone') ?? '';
            $email = $request->get('email') ?? '';
            $ownerName = $request->get('ownerName') ?? '';
            $ownerPhone = $request->get('ownerPhone') ?? '';
            $ownerEmail = $request->get('ownerEmail') ?? '';
            $cityId = $request->get('cityId') ?? '';
            $postalcode = $request->get('postalcode') ?? '';
            $address = $request->get('address') ?? '';
            $latitude = $request->get('latitude') ?? '';
            $logitude = $request->get('logitude') ?? '';
            $delivery = $request->get('delivery') ?? 'no';
            $distance = $request->get('distance') ?? '';
            // $userName = $request->get('userName') ?? '';
            $pwd = $request->get('pwd') ?? '';
            $confirmPwd = $request->get('ConPwd') ?? '';
            $image = $request->file('img_file') ?? null;
            $imageName = '';

            if ($storeName == "") {
                return JsonUtil::getResponse(false, "Store Name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($this->vendor->isVendorExists($storeName)) {
                return JsonUtil::getResponse(false, "Store Name is already exists!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($phone)) {
                return JsonUtil::getResponse(false, "Phone number is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isNumeric($phone)) {
                return JsonUtil::getResponse(false, "Phone number accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isPhoneNumber($phone)) {
                return JsonUtil::getResponse(false, "Please enter a valid phone number!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($this->vendor->isPhoneNumberAlreadyExists($phone)) {
                return JsonUtil::getResponse(false, "Phone number is already exists!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($email != "") {
                if (!RegexUtil::isEmail($email)) {
                    return JsonUtil::getResponse(false, "Please enter a valid email!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
            }


            if (empty($cityId)) {
                return JsonUtil::getResponse(false, "Please select a City / Town!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($postalcode)) {
                return JsonUtil::getResponse(false, "Postal code is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isNumeric($postalcode)) {
                return JsonUtil::getResponse(false, "Postal code accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($postalcode) < 4) {
                return JsonUtil::getResponse(false, "Postal code accepts only four numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($postalcode) > 4) {
                return JsonUtil::getResponse(false, "Postal code accepts only four numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($address)) {
                return JsonUtil::getResponse(false, "Address is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($address) > 200) {
                return JsonUtil::getResponse(false, "Address accepts only 200 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($latitude)) {
                return JsonUtil::getResponse(false, "Latitude is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($logitude)) {
                return JsonUtil::getResponse(false, "Logitude is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($delivery)) {
                return JsonUtil::getResponse(false, "Please select delivery availability!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($delivery == 'yes') {
                if (empty($distance)) {
                    return JsonUtil::getResponse(false, "Max delivery distance is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif (!RegexUtil::isNumeric($distance)) {
                    return JsonUtil::getResponse(false, "Max delivery distance accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
            }

            if (empty($ownerName)) {
                return JsonUtil::getResponse(false, "Owner Name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($ownerPhone)) {
                return JsonUtil::getResponse(false, "Owner Phone number is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isPhoneNumber($ownerPhone)) {
                return JsonUtil::getResponse(false, "Invalid owner phone number!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($ownerEmail != "") {
                if (!RegexUtil::isEmail($ownerEmail)) {
                    return JsonUtil::getResponse(false, "Invalid owner email!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
            }
            // if (empty($userName)) {
            //     return JsonUtil::getResponse(false, "Username is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            // }

            if (empty($pwd)) {
                return JsonUtil::getResponse(false, "Password is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($confirmPwd)) {
                return JsonUtil::getResponse(false, "Confirm password is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($pwd != $confirmPwd) {
                return JsonUtil::getResponse(false, "Passwords are mismatched!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($image == null) {
                return JsonUtil::getResponse(false, "Image is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } else {
                $ext = $image->getClientOriginalExtension();
                $imageSize = getimagesize($image);
                if ($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {

                    return JsonUtil::getResponse(false, "Supported file formats are - png, jpg, jpeg!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif ($image->getSize() > (1024 * 1000 * 2)) {
                    return JsonUtil::getResponse(false, "Maximum supported file size is 2 MB!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                // Upload Profile Img
                $imageName = 'v_' . '_' . time() . '.' . $image->getClientOriginalExtension();
                //  dd($imageName);

                $upload = $image->storeAs('/vendor_image', $imageName);
            }

            try {
                $this->vendor->addVendor([
                    'store_name' => $storeName,
                    // 'username' => $userName,
                    'password' => Hash::make($pwd),
                    'store_image' => $imageName,
                    'store_phone' => $phone,
                    'store_email' => $email,
                    'owner_name' => $ownerPhone,
                    'owner_phone' => $ownerPhone,
                    'owner_email' => $ownerEmail,
                    'city_town_id' => $cityId,
                    'postal_code' => $postalcode,
                    'address' => $address,
                    'latitude' => $latitude,
                    'longitude' => $logitude,
                    'is_delivery_available' => $delivery,
                    'max_delivery_distance' => $distance,
                    'is_active' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $request->session()->get('admin_id', null)
                ]);

                return JsonUtil::getResponse(true, "Vendor added successfully!", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }

    public function editVendor(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId = $request->get('vendorId') ?? '';
            // dd($vendorId);
            if (empty($vendorId) || !RegexUtil::isNumeric($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return abort(404);
            }
            return view('admin.vendor.edit-vendor')->with([
                'currentPage' => 'vendorList',
                'city' => $this->admin->getCityAll(),
                'vendorId' => $vendorId,
                'data' => $this->vendor->getVendorDetailsByVendorId($vendorId),
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $vendorId = $request->get('vendorId') ?? '';

            $storeName = $request->get('sName') ?? '';
            // $phone = $request->get('phone') ?? '';
            $email = $request->get('email') ?? '';
            $ownerName = $request->get('ownerName') ?? '';
            $ownerPhone = $request->get('ownerPhone') ?? '';
            $ownerEmail = $request->get('ownerEmail') ?? '';
            $cityId = $request->get('cityId') ?? '';
            $postalcode = $request->get('postalcode') ?? '';
            $address = $request->get('address') ?? '';
            $latitude = $request->get('latitude') ?? '';
            $logitude = $request->get('logitude') ?? '';
            $delivery = $request->get('delivery') ?? 'no';
            $distance = $request->get('distance') ?? null;
            // $userName = $request->get('userName') ?? '';
            $pwd = $request->get('pwd') ?? '';
            $image = $request->file('img_file') ?? null;
            $imageName = '';

            if (empty($vendorId) || !RegexUtil::isNumeric($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return JsonUtil::getResponse(false, "Opps,something went wrong!Please refresh the page and try again!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $currentVendorName = $this->vendor->getVendorDetailsByVendorId($vendorId)->store_name;
            $currentImagePic = $this->vendor->getVendorDetailsByVendorId($vendorId)->store_image;


            if ($storeName == "") {
                return JsonUtil::getResponse(false, "Store Name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($this->vendor->isVendorExists($storeName)) {
                if ($this->vendor->isVendorNameAndIdMatched($vendorId, $storeName)) {
                    if ($currentVendorName != $storeName) {
                        return JsonUtil::getResponse(false, "Vendor name is already exists!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }
                }
            }

            if ($email != "") {
                if (!RegexUtil::isEmail($email)) {
                    return JsonUtil::getResponse(false, "Please enter a valid email!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
            }



            if (empty($cityId)) {
                return JsonUtil::getResponse(false, "Please select a City / Town!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($postalcode)) {
                return JsonUtil::getResponse(false, "Postal code is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isNumeric($postalcode)) {
                return JsonUtil::getResponse(false, "Postal code accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($postalcode) < 4) {
                return JsonUtil::getResponse(false, "Postal code accepts only four numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($postalcode) > 4) {
                return JsonUtil::getResponse(false, "Postal code accepts only four numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($address)) {
                return JsonUtil::getResponse(false, "Address is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($address) > 200) {
                return JsonUtil::getResponse(false, "Address accepts only 200 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($latitude)) {
                return JsonUtil::getResponse(false, "Latitude is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($logitude)) {
                return JsonUtil::getResponse(false, "Logitude is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($delivery)) {
                return JsonUtil::getResponse(false, "Please select delivery availability!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($delivery == 'yes') {
                if (empty($distance)) {
                    return JsonUtil::getResponse(false, "Max delivery distance is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif (!RegexUtil::isNumeric($distance)) {
                    return JsonUtil::getResponse(false, "Max delivery distance accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
            }



            // if (empty($userName)) {
            //     return JsonUtil::getResponse(false, "Username is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            // }

            // if (empty($pwd)) {
            //     return JsonUtil::getResponse(false, "Password is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            // }

            if ($image == null || empty($image)) {

                $imageName = $currentImagePic;

                // $errorMsg['imgErr'] = "Featured image is required";
            } else {
                $ext = $image->getClientOriginalExtension();

                $imageSize = getimagesize($image);
                // $width = $imageSize[0];
                // $height = $imageSize[1];

                if ($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {

                    return JsonUtil::getResponse(false, "Supported file formats are - png, jpg, jpeg!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif ($image->getSize() > (1024 * 1000 * 2)) {
                    return JsonUtil::getResponse(false, "Maximum supported file size is 2 MB!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                // Upload Profile Img
                $imageName = 's_' . '_' . time() . '.' . $image->getClientOriginalExtension();

                $upload = $image->storeAs('/vendor_image', $imageName);
            }

            try {
                $this->vendor->editVendor($vendorId, [
                    'store_name' => $storeName,
                    // 'username' => $userName,
                    'store_image' => $imageName,
                    'store_email' => $email,
                    'owner_name' => $ownerPhone,
                    'owner_phone' => $ownerPhone,
                    'owner_email' => $ownerEmail,
                    'city_town_id' => $cityId,
                    'postal_code' => $postalcode,
                    'address' => $address,
                    'latitude' => $latitude,
                    'longitude' => $logitude,
                    'is_delivery_available' => $delivery,
                    'max_delivery_distance' => $distance,
                    'is_active' => '1',
                    'updated_at' => now(),
                    'updated_by' => $request->session()->get('admin_id', null)
                ]);

                return JsonUtil::getResponse(true, "Vendor updated successfully!", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function getVendorDetailsById(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId = $request->get('vendorId') ?? '';
            $v = null;
            if (!empty($vendorId)) {
                try {
                    $data = $this->vendor->getVendorDetailsByVendorId($vendorId);
                    $v = view('admin.vendor.partials.view-vendor-details', [
                        'vendorData' => $data,
                    ])->render();
                    return response()->json(['html' => $v], 200);
                } catch (Exception $e) {
                    return JsonUtil::serverError();
                }
            } else {
                JsonUtil::serverError();
            }
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }

    public function deleteVendor(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $vendorId = $request->get('vendorId') ?? '';
            if (empty($vendorId) || !RegexUtil::isNumeric($vendorId) || !$this->vendor->isVendorIdValid($vendorId)) {
                return JsonUtil::getResponse(false, "Opps,something went wrong!Please refresh the page and try again!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            //soft delete
            try {
                $this->vendor->editVendor($vendorId, [
                    'is_active' => '0',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $request->session()->get('admin_id', null)
                ]);
                return JsonUtil::getResponse(true, "Vendor deleted successfully!", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function vendorResetPassword(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId =  $request->get('vendorId') ?? '';
            if (empty($vendorId) || !RegexUtil::isNumeric($vendorId)) {
                return JsonUtil::getResponse(false, "Invalid Id!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            $v = view('admin.vendor.partials.vendor-reset-password', [
                'vendorId' => $vendorId,
            ])->render();
            return response()->json(['html' => $v], 200);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $vendorId =  $request->get('vendorId') ?? '';
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
                return JsonUtil::getResponse(true, "Password is changed successfully !", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), 500);
                return JsonUtil::serverError();
            }
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }

    public function vendorActiveDeactive(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $vendorId = $request->get('vendor_id') ?? '';
            $is_active = $request->get('is_active') ?? '';
            if (empty($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($is_active == '1') {
                $status = 'activated';
            } else {
                $status = 'deactivated';
            }

            try {
                $this->vendor->editVendor($vendorId, [
                    'is_active' => $is_active,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                return JsonUtil::getResponse(true, "Vendor " . $status . " successfully !", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), 500);
                return JsonUtil::serverError();
            }
        }
    }

    public function vendorDetails(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId = $request->get('id') ?? '';

            if (empty($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return abort(404);
            }

            $data = $this->vendor->getVendorDetailsByVendorId($vendorId);

            // dd($data) ;
            return view('admin.vendor.vendor-details')->with([
                'currentPage' => 'vendor',
                'id' => $vendorId,
                'data' => $data,
            ]);
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }

    public function vendorItemLists(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId = $request->get('id') ?? '';
            $filter = $request->get('filter') ?? 'Cycle';

            if (empty($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return abort(404);
            }

            $data = $this->vendor->getVendorDetailsByVendorId($vendorId);

            if ($filter == 'Accessories') {

                $whereRaw = "p.vendor_id=? AND pt.product_type = ? or p.is_active ='0'";
                $whereParam = [$vendorId, 'Accessories'];
            } else {

                $whereRaw = "p.vendor_id=? AND pt.product_type = ? or p.is_active ='0'";
                $whereParam = [$vendorId, 'Cycle'];
            }



            $productData = $this->product->getAllProductsPublic($whereRaw, $whereParam);

            // dd($productData);
            return view('admin.vendor.vendor-item-list')->with([
                'currentPage' => 'vendor',
                'id' => $vendorId,
                'data' => $data,
                'productData' => $productData,
                'filter' => $filter,
                'sn' => 0,
            ]);
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }


    public function vendorAddCycle(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $vendorId = $request->get('id') ?? '';

            if (empty($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return abort(404);
            }

            $data = $this->vendor->getVendorDetailsByVendorId($vendorId);

            $maxdeliverydistance = $data->max_delivery_distance ?? null;
            $whereRaw = "p.vendor_id=? AND p.product_type_id = '2'";
            $whereParam = [$vendorId];
            $paginate = false;

            $accessories =  $this->product->getAllProductsPublic($whereRaw, $whereParam, $paginate);
            $whereRaw1 = "pa.product_type_id=?";
            $whereParam1 = [1];
            return view('admin.vendor.product.vendor-add-cycle')->with([
                'currentPage' => 'vendor',
                'id' => $vendorId,
                'data' => $data,
                'filter' => 'Cycle',
                'categories' => $this->product->getProductCategories(),
                'attribute' => $this->product->getAllProductAttribute($whereRaw1, $whereParam1),
                'unit' => $this->unit->getAllUnit(),
                'accessories' => $accessories,
                'maxdeliverydistance' => $maxdeliverydistance ?? null,
                'type' => 'cycle' ?? 'accessories',
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {

            $vendorId = $request->get('vendor_id') ?? '';
            if (empty($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return JsonUtil::getResponse(false, "Invalid Request!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            // dd($request);
            $catrgories = $request->get('catrgories') ?? [];
            $productName = $request->get('productName') ?? '';
            $productSlug = $request->get('productSlug') ?? '';
            $productDesc = $request->get('productDesc') ?? '';
            $thumbnail = $request->file('thumbnail') ?? null;
            $thumnailImageName = "";
            $extraImage = $request->file('extraImage') ?? [];

            $supportedPicExtensions = ["jpg", "jpeg", "png", "svg"];
            $initialStock = $request->get('initialStock') ?? '';
            $attributeId = $request->get('attributeId') ?? [];
            $atributeValue = $request->get('atributeValue') ?? [];
            $unitId = $request->get('unitId') ?? [];

            $relatedAccessories = $request->get('relatedAccessories') ?? [];
            $addCharge = $request->get('addCharge') ?? '';
            $depositeprice = $request->get('deposite_price') ?? '';
            $insuranceprice = $request->get('insurance_price') ?? '';
            $currency = $request->get('currency') ?? '';
            $planUnit = $request->get('planUnit') ?? [];
            // dd($planUnit);
            $price = $request->get('price') ?? [];

            // Is Home Delivery
            $ishomedelivery = $request->get('is_home_delivery') ?? '';
            $maxdistance = $request->get('maxdistance') ?? 0;
            $meter = 0;
            $meter = $maxdistance * 1000;
            $deliverycharge = $request->get('delivery_charge') ?? '';



            $data = [];
            $data1 = [];

            if (!empty($catrgories)) {
                if (count($catrgories) > 0) {
                    $catIds =  implode(",", $catrgories);
                } else {
                    $catIds = $catrgories ?? null;
                }
            }

            if (empty($productName)) {
                return JsonUtil::getResponse(false, "Product name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($productName) > 100) {
                return JsonUtil::getResponse(false, "Product name accepts only 100 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($this->product->productSlugIsAvliable($productSlug)) {
                return JsonUtil::getResponse(false, "This Product Slug is alredy Exists. Please Change The Slug !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($productDesc)) {
                return JsonUtil::getResponse(false, "Description is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($productDesc) > 200) {
                return JsonUtil::getResponse(false, "Description accepts only 200 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($thumbnail == null) {
                return JsonUtil::getResponse(false, "Picture is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } else {
                $ext = $thumbnail->getClientOriginalExtension();
                $imageSize = getimagesize($thumbnail);
                if ($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {
                    return JsonUtil::getResponse(false, "Supported file formats are - png, jpg, jpeg!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif ($thumbnail->getSize() > (1024 * 1000 * 2)) {
                    return JsonUtil::getResponse(false, "Maximum supported file size is 2 MB!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
                $thumnailImageName = 'IMG_' . 'Thumbnail' . time() . '.' . $thumbnail->getClientOriginalExtension();
                $upload = $thumbnail->storeAs('/product-image', $thumnailImageName);
            }


            $extraImg = [];
            if ($extraImage != null) {
                $testInput = 0;
                for ($i = 0; $i < count($extraImage); $i++) {
                    if (isset($extraImage[$i])) {
                        $ext = $extraImage[$i]->getClientOriginalExtension();
                        if (in_array(strtolower($ext), $supportedPicExtensions)) {
                            if ($extraImage[$i]->getSize() > (1024 * 1000 * 2)) {
                                return JsonUtil::getResponse(false, 'Extra Image Maximum supported file size is 2 MB !', JsonUtil::$_UNPROCESSABLE_ENTITY);
                            } else {
                                $extraImgName = 'IMG_' . Generator::getRandomString(5, false, false) . time() . '.' . $ext;
                                $upload = $extraImage[$i]->storeAs('/product-image', $extraImgName);
                                if ($upload) {
                                    array_push($extraImg, $extraImgName);
                                } else {
                                    return JsonUtil::getResponse(false, 'Extra Image cannot be uploaded. Something went wrong !', JsonUtil::$_INTERNAL_SERVER_ERROR);
                                }
                            }
                        } else {
                            return JsonUtil::getResponse(false, 'Extra image Invalid file format. Supports only jpg, jpeg, svg and png !', JsonUtil::$_UNPROCESSABLE_ENTITY);
                        }
                    }
                }
                if (count($extraImage) == $testInput) {
                }
            }


            if (empty($initialStock)) {
                return JsonUtil::getResponse(false, "Initial stock is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isNumeric($initialStock)) {
                return JsonUtil::getResponse(false, "Initial stock accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();
            try {
                $productId =  $this->product->addProduct([
                    'vendor_id' => $vendorId,
                    'product_type_id' => 1,
                    'is_active' => "1",
                    'product_category_ids' => $catIds ?? null,
                    'product_name' => $productName,
                    'product_slug' => $productSlug,
                    'product_description' => $productDesc,
                    'product_thumbnail' => $thumnailImageName,
                    'product_images' => implode(",", $extraImg),
                    'initial_stock' => $initialStock,
                    'remaining_stock' => $initialStock,
                    'related_accessories' => implode(",", $relatedAccessories),

                    'is_home_delivery' => $ishomedelivery ?? null,
                    'max_delivery_distance' => $meter ?? null,
                    'delivery_charge' => $deliverycharge ?? null,

                    'created_at' => date('Y-m-d H:i:s')
                ]);

                foreach ($attributeId as $key => $val) {

                    if (!empty($attributeId[$key])) {

                        if (empty($atributeValue[$key]) && !empty($unitId[$key])) {
                            return JsonUtil::getResponse(false, "Attribute value is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                        }

                        $val = [
                            'vendor_id' => $vendorId,
                            'product_id' => $productId,
                            'product_attr_id' => $attributeId[$key] ?? null,
                            'attribute_value' => $atributeValue[$key],
                            'attribute_value_unit_id' => $unitId[$key] ?? null,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];

                        array_push($data, $val);
                    }
                }

                if (empty($currency)) {
                    return JsonUtil::getResponse(false, "Please select currency!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                if (empty($addCharge)) {
                    return JsonUtil::getResponse(false, "Additional Charge is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif (!RegexUtil::isFloat($addCharge)) {
                    return JsonUtil::getResponse(false, "Additional Charge accepts only numaric!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                if (!empty($depositeprice)) {
                    if (!RegexUtil::isFloat($depositeprice)) {
                        return JsonUtil::getResponse(false, "Deposite price accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }
                }

                if (!empty($insuranceprice)) {
                    if (!RegexUtil::isFloat($insuranceprice)) {
                        return JsonUtil::getResponse(false, "Insurance price accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }
                }

                if (!empty($addCharge)) {

                    $this->product->productUpdate($productId, [
                        'min_charge' => $addCharge,
                        'deposite_price' => $depositeprice ?? null,
                        'insurance_price' => $insuranceprice ?? null,
                    ]);
                }


                foreach ($planUnit as $key => $value) {

                    if (empty($price[$key])) {
                        return JsonUtil::getResponse(false, $planUnit[$key] . " price is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    } elseif (!RegexUtil::isFloat($price[$key])) {
                        return JsonUtil::getResponse(false, "Price accepts only numaric for " . $planUnit[$key], JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }



                    $value = [
                        'vendor_id' => $vendorId,
                        'product_id' => $productId,
                        'pricing_plan_value' => 1,
                        'pricing_plan_unit' => $planUnit[$key],
                        'price' => $price[$key],
                        'currency' => $currency,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    array_push($data1, $value);
                }
                // dd(1);
                $this->product->addProductDetails($data);
                $this->product->addProductPricing($data1);
                DB::commit();
                return JsonUtil::getResponse(true, "Cycle added successfully!", JsonUtil::$_STATUS_OK, $productId);
            } catch (Exception $e) {
                DB::rollBack();
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
                return JsonUtil::serverError();
            }
        } else {
            JsonUtil::methodNotAllowed();
        }
    }

    public function vendorAddAccessories(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            // dd(1);
            $vendorId = $request->get('id') ?? '';

            if (empty($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return abort(404);
            }


            $data = $this->vendor->getVendorDetailsByVendorId($vendorId);
            $maxdeliverydistance = $data->max_delivery_distance ?? null;
            $whereRaw1 = "pa.product_type_id=?";
            $whereParam1 = [2];
            return view('admin.vendor.product.vendor-add-accessories')->with([
                'currentPage' => 'vendor',
                'id' => $vendorId,
                'data' => $data,
                'filter' => 'Accessories',
                'categories' => $this->product->getProductCategories(),
                'attribute' => $this->product->getAllProductAttribute($whereRaw1, $whereParam1),
                'unit' => $this->unit->getAllUnit(),
                'maxdeliverydistance' => $maxdeliverydistance ?? null,
                'type' => 'acces',
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {

            $vendorId = $request->get('vendor_id') ?? '';
            if (empty($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return JsonUtil::getResponse(false, "Invalid Request!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }


            // dd($request);
            $catrgories = $request->get('catrgories') ?? [];
            $productName = $request->get('productName') ?? '';
            $productSlug = $request->get('productSlug') ?? '';
            $productDesc = $request->get('productDesc') ?? '';
            $thumbnail = $request->file('thumbnail') ?? null;
            $thumnailImageName = "";
            $extraImage = $request->file('extraImage') ?? [];

            $supportedPicExtensions = ["jpg", "jpeg", "png", "svg"];
            $initialStock = $request->get('initialStock') ?? '';
            $attributeId = $request->get('attributeId') ?? [];
            $atributeValue = $request->get('atributeValue') ?? [];
            $unitId = $request->get('unitId') ?? [];

            $relatedAccessories = $request->get('relatedAccessories') ?? [];

            $addCharge = $request->get('addCharge') ?? '';
            $currency = $request->get('currency') ?? '';
            $planUnit = $request->get('planUnit') ?? '';

            $price = $request->get('price') ?? '';

            $ishomedelivery = $request->get('is_home_delivery') ?? '';
            $maxdistance = $request->get('maxdistance') ?? '';
            $meter = 0;
            $meter = $maxdistance * 1000;
            $deliverycharge = $request->get('delivery_charge') ?? '';



            $data = [];
            $data1 = [];

            if (!empty($catrgories)) {
                if (count($catrgories) > 0) {
                    $catIds =  implode(",", $catrgories);
                } else {
                    $catIds = $catrgories ?? null;
                }
            }

            if (empty($productName)) {
                return JsonUtil::getResponse(false, "Product name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($productName) > 100) {
                return JsonUtil::getResponse(false, "Product name accepts only 100 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($this->product->productSlugIsAvliable($productSlug)) {
                return JsonUtil::getResponse(false, "This Product Slug is alredy Exists. Please Change The Slug !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($productDesc)) {
                return JsonUtil::getResponse(false, "Description is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($productDesc) > 200) {
                return JsonUtil::getResponse(false, "Description accepts only 200 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($thumbnail == null) {
                return JsonUtil::getResponse(false, "Picture is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } else {
                $ext = $thumbnail->getClientOriginalExtension();
                $imageSize = getimagesize($thumbnail);
                if ($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {
                    return JsonUtil::getResponse(false, "Supported file formats are - png, jpg, jpeg!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                } elseif ($thumbnail->getSize() > (1024 * 1000 * 2)) {
                    return JsonUtil::getResponse(false, "Maximum supported file size is 2 MB!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
                $thumnailImageName = 'IMG_' . 'Thumbnail' . time() . '.' . $thumbnail->getClientOriginalExtension();
                $upload = $thumbnail->storeAs('/product-image', $thumnailImageName);
            }


            $extraImg = [];
            if ($extraImage != null) {
                $testInput = 0;
                for ($i = 0; $i < count($extraImage); $i++) {
                    if (isset($extraImage[$i])) {
                        $ext = $extraImage[$i]->getClientOriginalExtension();
                        if (in_array(strtolower($ext), $supportedPicExtensions)) {
                            if ($extraImage[$i]->getSize() > (1024 * 1000 * 2)) {
                                return JsonUtil::getResponse(false, 'Extra Image Maximum supported file size is 2 MB !', JsonUtil::$_UNPROCESSABLE_ENTITY);
                            } else {
                                $extraImgName = 'IMG_' . Generator::getRandomString(5, false, false) . time() . '.' . $ext;
                                $upload = $extraImage[$i]->storeAs('/product-image', $extraImgName);
                                if ($upload) {
                                    array_push($extraImg, $extraImgName);
                                } else {
                                    return JsonUtil::getResponse(false, 'Extra Image cannot be uploaded. Something went wrong !', JsonUtil::$_INTERNAL_SERVER_ERROR);
                                }
                            }
                        } else {
                            return JsonUtil::getResponse(false, 'Extra image Invalid file format. Supports only jpg, jpeg, svg and png !', JsonUtil::$_UNPROCESSABLE_ENTITY);
                        }
                    }
                }
                if (count($extraImage) == $testInput) {
                }
            }


            if (empty($initialStock)) {
                return JsonUtil::getResponse(false, "Initial stock is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isNumeric($initialStock)) {
                return JsonUtil::getResponse(false, "Initial stock accepts only numbers!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();
            try {
                $productId =  $this->product->addProduct([
                    'vendor_id' => $vendorId,
                    'product_type_id' => 2,
                    'is_active' => "1",
                    'product_category_ids' => $catIds ?? null,
                    'product_name' => $productName,
                    'product_slug' => $productSlug,
                    'product_description' => $productDesc,
                    'product_thumbnail' => $thumnailImageName,
                    'product_images' => implode(",", $extraImg),
                    'initial_stock' => $initialStock,
                    'remaining_stock' => $initialStock,
                    'related_accessories' => implode(",", $relatedAccessories),
                    'is_home_delivery' => $ishomedelivery ?? null,
                    'max_delivery_distance' => $meter ?? null,
                    'delivery_charge' => $deliverycharge ?? null,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                if (empty($currency)) {
                    return JsonUtil::getResponse(false, "Please select currency!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }



                if (!empty($addCharge) && !RegexUtil::isFloat($addCharge)) {
                    return JsonUtil::getResponse(false, "Additional Charge accepts only numaric!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                foreach ($attributeId as $key => $val) {
                    // dd('entered');
                    if (!empty($attributeId[$key])) {
                        if (empty($atributeValue[$key]) && !empty($unitId[$key])) {
                            return JsonUtil::getResponse(false, "Attribute value is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                        }
                        $val = [
                            'vendor_id' => $vendorId,
                            'product_id' => $productId,
                            'product_attr_id' => $attributeId[$key] ?? null,
                            'attribute_value' => $atributeValue[$key],
                            'attribute_value_unit_id' => $unitId[$key] ?? null,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];

                        array_push($data, $val);
                    }
                }

                if (!empty($addCharge)) {

                    $this->product->productUpdate($productId, [
                        'min_charge' => $addCharge,
                        'deposite_price' => null,
                        'insurance_price' => null,
                    ]);
                }



                if (empty($price)) {
                    return JsonUtil::getResponse(false, "Price is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                }
                $value5 = [
                    'vendor_id' => $vendorId,
                    'product_id' => $productId,
                    'pricing_plan_value' => 1,
                    'pricing_plan_unit' => $planUnit,
                    'price' => $price,
                    'currency' => $currency,
                    'created_at' => date('Y-m-d H:i:s')
                ];





                $this->product->addProductDetails($data);
                $this->product->addProductPricing($value5);
                DB::commit();
                return JsonUtil::getResponse(true, "Accessories added successfully!", JsonUtil::$_STATUS_OK, $productId);
            } catch (Exception $e) {
                DB::rollBack();
                // return JsonUtil::serverError();
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        } else {
            JsonUtil::methodNotAllowed();
        }
    }

    public function activeDeactiveProduct(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $productId = $request->get('product_id') ?? '';
            $status = $request->get('status') ?? '';
            if (empty($productId) || !$this->product->isProductIdValid($productId)) {
                return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            try {

                $this->product->productUpdate($productId, [
                    'is_active' => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                if ($status == '1') {
                    $p = 'active';
                } else {
                    $p = 'deactivate';
                }
                return JsonUtil::getResponse(true, "Product is " . $p . " successfully !", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                // return JsonUtil::getResponse(false, $e->getMessage(), 500);
                return JsonUtil::serverError();
            }
        }
    }

    public function vendorOrders(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId = $request->get('id') ?? '';
            $filter = $request->get('filter') ?? 'All';

            if (empty($vendorId) || !$this->vendor->isVendorValid($vendorId)) {
                return abort(404);
            }

            $data = $this->vendor->getVendorDetailsByVendorId($vendorId);

            if ($filter == 'Accessories') {

                $whereRaw = 'p.vendor_id=? AND pt.product_type = ?';
                $whereParam = [$vendorId, 'Accessories'];
            } else {

                $whereRaw = 'p.vendor_id=? AND pt.product_type = ?';
                $whereParam = [$vendorId, 'Cycle'];
            }



            $orderData = $this->vendor->getVendorOrders($vendorId);

            // dd($orderData) ;
            return view('admin.vendor.vendor-all-orders')->with([
                'currentPage' => 'vendor',
                'id' => $vendorId,
                'data' => $data,
                'orderData' => $orderData,
                'filter' => $filter,
                'sn' => 0,
            ]);
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }

    public function vendorRatings(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $vendorId = $request->get('id') ?? '';

            $ongoingData = $this->product->getReviewByVendorId($vendorId, 20, 'approved');

            if (!empty($vendorId) && $this->vendor->isVendorIdValid($vendorId)) {

                $data = $this->vendor->getVendorDetailsByVendorId($vendorId);
                return view('admin.vendor.vendor-ratings')->with([
                    'data' => $data,
                    'currentPage' => 'vendor',
                    'id' => $vendorId,
                    'approvedData' => $ongoingData,
                    'sn' => ($ongoingData->currentPage() - 1) * $ongoingData->perPage(),
                ]);
            } else {
                return abort(404);
            }
        } else {
            JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }

    public function paymentAggrement(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $vendorList = $this->vendor->getVendors('1=? AND agreement.id IS NULL',[1]) ;
            $agreementData = $this->vendor->getAgreementsGroupByVendor() ;

            // dd($agreementData) ;


            return view('admin.payment-aggrement')->with([
                'vendorList' => $vendorList,
                'currentPage' => 'Payment Aggrement',
                'agreements' => $agreementData,
                'sn' => ($agreementData->currentPage() - 1) * $agreementData->perPage(),
                
            ]);
        } elseif(HttpMethodUtil::isMethodPost()){
            $agreementName = $request->get('agreement_name') ?? '' ;
            $vendor = $request->get('vendor') ?? '' ;
            $vendorPerCentage = $request->get('vendor_per') ?? '' ;
            $agreementValidity = $request->get('agreement_validity') ?? '' ;
            $governedBy = $request->get('agreement_governed_by') ?? '' ;

            if(empty($agreementName)){
                return JsonUtil::getResponse(false,"Please enter agreement name",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            }

            if(empty($vendor)){
                return JsonUtil::getResponse(false,"Please select vendor",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            } elseif(!$this->vendor->isVendorIdValid($vendor)){
                return JsonUtil::getResponse(false,"invalid vendor",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            }

            $vendorData = $this->vendor->getVendorDetailsByVendorId($vendor) ;

            // dd($vendorData) ;

            if(empty($vendorPerCentage)){
                return JsonUtil::getResponse(false,"Vendor Percentage is required",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            } elseif(!RegexUtil::isNumeric($vendorPerCentage)){
                return JsonUtil::getResponse(false,"Invalid Vendor Percentage",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            } elseif($vendorPerCentage > 100 || $vendorPerCentage < 1) {
                return JsonUtil::getResponse(false,"Invalid Vendor Percentage",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            }

            if(empty($agreementValidity)){
                return JsonUtil::getResponse(false,"Agreement Validity is required",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            } elseif(!RegexUtil::isNumeric($agreementValidity)){
                return JsonUtil::getResponse(false,"Please enter Agreement Validity in days",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            }

            if(empty($governedBy)){
                return JsonUtil::getResponse(false,"Agreement Governed By is required",JsonUtil::$_UNPROCESSABLE_ENTITY) ;
            } 

            if(empty($vendorData->agreement_valid_till) || $vendorData->agreement_valid_till <  date('Y-m-d')){

                $data = [
                    'vendor_id' => $vendor ,
                    'agreement_name' => $agreementName ,
                    'vendor_percentage' => $vendorPerCentage ,
                    'valid_from' => date('Y-m-d'),
                    'valid_till' => date('Y-m-d',strtotime(' + '.$agreementValidity.' days')) ,
                    'vendor_agree_at' => null ,
                    'governed_by' => $governedBy ,
                    'created_at' => now() ,
                    'created_by' =>  $request->session()->get('admin_id', null),
                ] ;

            } else {

                $data = [
                    'vendor_id' => $vendor ,
                    'agreement_name' => $agreementName ,
                    'vendor_percentage' => $vendorPerCentage ,
                    'valid_from' => date('Y-m-d',strtotime($vendorData->agreement_valid_till.' +1  days')),
                    'valid_till' => date('Y-m-d',strtotime($vendorData->agreement_valid_till.' + '.$agreementValidity.' days')),
                    'vendor_agree_at' => null ,
                    'governed_by' => $governedBy ,
                    'created_at' => now() ,
                    'created_by' =>  $request->session()->get('admin_id', null),
                ] ;

            }

            DB::beginTransaction();

            try {
        
        
                $path = base_path().'/assets/uploads';
     


                $agreementId = $this->vendor->addVendorAgreement($data) ;
                $agreementPath =  $path . '/'.'vendor-agreement';
                $agreementFileName ='agreement_copy_'.$vendor.$agreementId.'_'.Generator::getRandomString(30).'.pdf';

                $data['num'] = Self::getIndianCurrency($data['vendor_percentage']) ;

                   
                $pdf = PDF::loadView('agreement-pdf', [
                    'agreement_data' => $data ,
                    'vendor_data' => $vendorData, 
                ]);
        
                $pdf->save($agreementPath.'/'.$agreementFileName);

                $this->vendor->updateVendorAgreement($agreementId,['agreement_file'=>$agreementFileName]) ;



                DB::commit();
                return JsonUtil::getResponse(True , "Agreement added successfully" , JsonUtil::$_STATUS_OK) ;
            } catch (Exception $e) {

                DB::rollBack();

                return $e->getMessage();
                return JsonUtil::serverError();
            }

      
        }
    }
    

    public static function getIndianCurrency($number)
	{
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();
		$words = array(0 => '', 1 => 'one', 2 => 'two',
			3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
			7 => 'seven', 8 => 'eight', 9 => 'nine',
			10 => 'ten', 11 => 'eleven', 12 => 'twelve',
			13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
			16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
			19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
			40 => 'forty', 50 => 'fifty', 60 => 'sixty',
			70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
		$digits = array('', 'hundred','thousand','lakh', 'crore');
		while( $i < $digits_length ) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' And ' : null;
				$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		$paise = ($decimal > 0) ? " And " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) : '';
		return ($Rupees ? $Rupees : '') .$paise;
	}
}
