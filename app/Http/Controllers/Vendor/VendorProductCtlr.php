<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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
use Illuminate\Support\Facades\File;

class VendorProductCtlr extends Controller
{
    private $product;
    private $vendor;
    private $unit;
    private $booking;
    public function __construct()
    {
        $this->product = new Product();
        $this->vendor = new Vendor();
        $this->unit = new Unit();
        $this->booking = new Booking();
    }

    public function index(Request $request)
    {
        $action = $request->get('action') ?? '';
        switch ($action) {
            case 'add-new-cycle':
                return $this->addCycle($request);
                break;
            case 'all-product':
                return $this->allProducts($request);
                break;
            case 'edit-product':
                return $this->editProduct($request);
                break;
            case 'view-product-partials':
                return $this->viewProductPartials($request);
                break;
            case 'delete-product':
                return $this->deleteProduct($request);
                break;
            case 'active-product':
                return $this->activeProduct($request);
                break;
            case 'add-new-accessories':
                return $this->addAccessories($request);
                break;
            default:
                return abort(404);
                break;
        }
    }

    public function allProducts(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $whereRaw = "p.vendor_id=? or p.is_active = '0'";
            $whereParam = [$request->session()->get('vendor_id')];
            $productData = $this->product->getAllProductsPublic($whereRaw, $whereParam, true);
            // dd($productData);
            return view('vendor.product.all-product')->with([
                'currentPage' => 'allProducts',
                'productTypes' => $this->product->getProductTypes(),
                'allProducts' => $productData,
                'sn' => ($productData->currentPage() - 1) * $productData->perPage(),
            ]);
        }
    }

    public function addCycle(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $maxdeliverydistance = $request->session()->get('max_delivery_distance') ?? null;
            $whereRaw = "p.vendor_id=? AND p.product_type_id = '2'";
            $whereParam = [$request->session()->get('vendor_id')];

            $whereRaw1 = "pa.product_type_id=?";
            $whereParam1 = [1];
            // dd($this->product->getAllProductAttribute($whereRaw1,$whereParam1));
            return view('vendor.product.add-new-cycle')->with([
                'currentPage' => 'addCycle',
                'categories' => $this->product->getProductCategories(),
                'attribute' => $this->product->getAllProductAttribute($whereRaw1, $whereParam1),
                'unit' => $this->unit->getAllUnit(),
                'accessories' => $this->product->getAllProductsPublic($whereRaw, $whereParam, $paginate = true),
                'maxdeliverydistance' => $maxdeliverydistance,
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
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
                    'vendor_id' => $request->session()->get('vendor_id', null),
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
                            'vendor_id' => $request->session()->get('vendor_id', null),
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
                        'vendor_id' => $request->session()->get('vendor_id'),
                        'product_id' => $productId,
                        'pricing_plan_value' => 1,
                        'pricing_plan_unit' => $planUnit[$key],
                        'price' => $price[$key],
                        'currency' => $currency,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    array_push($data1, $value);
                }

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

    public function addAccessories(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $maxdeliverydistance = $request->session()->get('max_delivery_distance') ?? null;
            $whereRaw1 = "pa.product_type_id=?";
            $whereParam1 = [2];
            return view('vendor.product.add-new-accessories')->with([
                'currentPage' => 'addAccessories',
                'categories' => $this->product->getProductCategories(),
                'attribute' => $this->product->getAllProductAttribute($whereRaw1, $whereParam1),
                'unit' => $this->unit->getAllUnit(),
                'maxdeliverydistance' => $maxdeliverydistance,
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
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
            $planUnit = $request->get('planUnit') ?? 'hour';

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
                    'vendor_id' => $request->session()->get('vendor_id', null),
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
                            'vendor_id' => $request->session()->get('vendor_id', null),
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
                    'vendor_id' => $request->session()->get('vendor_id'),
                    'product_id' => $productId,
                    'pricing_plan_value' => 1,
                    'pricing_plan_unit' => $planUnit,
                    'price' => $price,
                    'currency' => $currency,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                // /dd(1);
                $this->product->addProductDetails($data);
                $this->product->addProductPricing($value5);
                DB::commit();
                return JsonUtil::getResponse(true, "Accessories added successfully!", JsonUtil::$_STATUS_OK, $productId);
            } catch (Exception $e) {
                DB::rollBack();
                return JsonUtil::serverError();
                // return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        } else {
            JsonUtil::methodNotAllowed();
        }
    }

    public function viewProductPartials(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $productId = $request->get('productId') ?? '';
            if (empty($productId) || !RegexUtil::isNumeric($productId)) {
                return JsonUtil::getResponse(false, "Invalid product Id!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            $v = null;
            $data = [];
            $dataImg = [];

            try {
                $products = $this->product->getProductByProductId($request->session()->get('vendor_id'), $productId);
                $catId = $products->product_category_ids;
                if ($catId != null) {
                    $catArray = explode(',', $catId);
                    if (count($catArray) > 1) {
                        foreach ($catArray as $c) {
                            $catNames = $this->product->getCategoryByCategoryId($c)->product_category;

                            array_push($data, $catNames);
                        }
                        $catNames = implode(',', $data);
                    } else {
                        $catNames = $this->product->getCategoryByCategoryId($catId)->product_category;
                    }
                } else {
                    $catNames = 'N/A';
                }

                // For Accessories Image 
                $products = $this->product->getProductByProductId($request->session()->get('vendor_id'), $productId);
                $relatedAccessories = $products->related_accessories;
                if ($relatedAccessories != null) {
                    $accessoriesArray = explode(',', $relatedAccessories);
                    if (count($accessoriesArray) > 1) {
                        foreach ($accessoriesArray as $access) {
                            $accessoriesImg = $this->product->getAccessoriesById($access)->product_thumbnail;

                            array_push($dataImg, $accessoriesImg);
                        }
                        $accessoriesImg = implode(',', $dataImg);
                    } else {
                        $accessoriesImg = $this->product->getAccessoriesById($relatedAccessories)->product_thumbnail;
                    }
                } else {
                    $accessoriesImg = 'N/A';
                }

                $v = view('vendor.product.partials.view-product-details', [
                    'productsData' => $products,
                    'categoryNames' => $catNames ?? 'N/A',
                    'accessoriesImage' => $accessoriesImg ?? 'N/A',
                    'productPrice' => $this->product->getVendorProductPriceById($request->session()->get('vendor_id'), $productId),
                ])->render();
                return response()->json(['html' => $v], 200);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        } else {
            JsonUtil::methodNotAllowed();
        }
    }

    public function editProduct(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $productId = $request->get('id') ?? '';
            $productData = $this->product->getProductByProductId($request->session()->get('vendor_id'), $productId);
            $maxDel = $productData->max_delivery_distance;
            $whereRaw = "p.vendor_id=? or p.is_active = '0'";
            $whereParam = [$request->session()->get('vendor_id')];

            return view('vendor.product.edit-product')->with([
                'currentPage' => 'allProducts',
                'attribute' => $this->product->getAllProductAttribute(),
                'accessories' => $this->product->getAllProductsPublic($whereRaw, $whereParam, true, 20),
                'unit' => $this->unit->getAllUnit(),
                'productDetails' => $this->product->getProductDetailsByProductId($request->session()->get('vendor_id'), $productId),
                'vendorProductPricing' => $this->product->vendorProductPricing($request->session()->get('vendor_id'), $productId),
                'productTypes' => $this->product->getProductTypes(),
                'categories' => $this->product->getProductCategories(),
                'productdata' => $productData,
                'maxDel' => $maxDel,
                'isAccessories' => $this->product->isproductIsAccessories($productId),
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $productId = $request->get('id') ?? '';
            if ($productId == "" || !RegexUtil::isNumeric($productId) || !$this->product->isProductIdValid($productId)) {
                return JsonUtil::getResponse(false, "Invalid Id...", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            // For Product Table
            $productTypeId = $request->get('productTypeId') ?? '';
            $catrgories = $request->get('catrgories') ?? [];
            $productName = $request->get('productName') ?? '';
            $productSlug = $request->get('productSlug') ?? '';
            $is_home_delivery = $request->get('is_home_delivery') ?? '';
            $maxdistance = $request->get('maxdistance') ?? '';
            // dd($maxdistance);
            $meter = 0;
            $meter = $maxdistance * 1000;
            $delivery_charge = $request->get('delivery_charge') ?? '';
            $relatedAccessories = $request->get('relatedAccessories') ?? [];
            $picture = $request->file('picture') ?? '';
            $old_picture = $request->get('old_picture') ?? '';
            $extraImage = $request->file('extraImage') ?? [];
            $old_extraImg = $request->get('old_extraImg') ?? [];
            $updatedExtraImages = [];
            $supportedPicExtensions = ["jpg", "jpeg", "png", "svg"];
            $initialStock = $request->get('initialStock') ?? '';
            $product_desc = $request->get('product_desc') ?? '';

            // For Product Details Table
            $attributeId = $request->get('attributeId') ?? [];
            $atributeValue = $request->get('atributeValue') ?? [];
            $unitId = $request->get('unitId') ?? [];
            $prev_product_details = $request->get('prev_product_details') ?? [];
            $currency = $request->get('currency') ?? '';
            $depositeprice = $request->get('deposite_price') ?? '';
            $insuranceprice = $request->get('insurance_price') ?? '';
            $addCharge = $request->get('addCharge') ?? '';
            $productDetailsData = [];

            // For Vendor Product Pricing Table 
            $planUnit = $request->get('planUnit') ?? [];
            $planUnitAcc = $request->get('planUnitAcc') ?? '';
            $priceAcc = $request->get('priceAcc') ?? '';
            $price = $request->get('price') ?? [];
            $prev_product_price = $request->get('prev_product_price') ?? [];
            $productPricingData = [];


            $pictureImageName = null;
            // Picture
            if ($picture == null || empty($picture)) {
                $pictureImageName =  $old_picture;
            } else {
                $ext = $picture->getClientOriginalExtension();
                $imageSize = getimagesize($picture);
                // $width = $imageSize[0];
                // $height = $imageSize[1];

                if ($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg' && $ext != 'webp' && $ext != 'svg') {
                    return JsonUtil::getResponse(false, "Supported file formats are - png, jpg, jpeg, svg!", JsonUtil::$_BAD_REQUEST);
                } elseif ($picture->getSize() > (1024 * 1024 * 2)) {
                    return JsonUtil::getResponse(false, "Maximum supported file size is 2 MB !", JsonUtil::$_BAD_REQUEST);
                }
                $pictureData = $this->product->getProductByProductId($request->session()->get('vendor_id'), $productId);
                $pictureImage = $pictureData->product_thumbnail;
                if (File::exists(base_path("assets/uploads/product-image/" . '/' . $pictureImage))) {
                    File::delete(base_path("assets/uploads/product-image/" . '/' . $pictureImage));
                }
                $pictureImageName = 'IMG_' . 'Picture_' . time() . '.' . $picture->getClientOriginalExtension();
                try {
                    $upload = $picture->storeAs('/product-image', $pictureImageName);
                    if (!$upload) {
                        return JsonUtil::serverError();
                    }
                } catch (Exception $e) {
                    return JsonUtil::serverError();
                }
            }

            // Extra Image
            if ($extraImage != null) {
                $testInput = 0;
                foreach ($extraImage as $value) {
                    $ext = $value->getClientOriginalExtension();

                    if (!in_array(strtolower($ext), $supportedPicExtensions)) {
                        return JsonUtil::getResponse(false, "Invalid file type, Supports only jpg, jpeg, png, svg", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    } elseif ($value->getSize() > (2024 * 1000 * 2)) {
                        return JsonUtil::getResponse(false, 'Variation Image supported file size is 2 MB', JsonUtil::$_UNPROCESSABLE_ENTITY);
                    } else {
                        $extraImagename = 'IMG_' . 'ExtraImage_' . Generator::getRandomString(5, false, false) . time() . '.' . $ext;
                        $uploadImg = $value->storeAs('/product-image', $extraImagename);

                        if ($uploadImg) {
                            $testInput++;
                            array_push($updatedExtraImages, $extraImagename);
                        } else {
                            return JsonUtil::getResponse(false, 'Image cannot be uploaded. Something went wrong', JsonUtil::$_INTERNAL_SERVER_ERROR);
                        }
                    }
                }
            }


            DB::beginTransaction();
            try {

                // Update Product Table
                $productData = [
                    'vendor_id' => $request->session()->get('vendor_id', null),
                    'product_type_id' => $productTypeId,
                    'product_category_ids' => implode(",", $catrgories),
                    'product_name' => $productName,
                    'product_slug' => $productSlug,
                    'product_description' => $product_desc,
                    'product_thumbnail' => $pictureImageName,
                    'product_images' => substr((count($updatedExtraImages) > 0 ? implode(",", $updatedExtraImages) . ',' : '') . (count($old_extraImg) > 0 ? implode(",", $old_extraImg) . ',' : ''), 0, -1),
                    'initial_stock' => $initialStock,
                    'remaining_stock' => $initialStock,
                    'related_accessories' => implode(",", $relatedAccessories),
                    'is_home_delivery' => $is_home_delivery ?? null,
                    'max_delivery_distance' => $meter ?? null,
                    'delivery_charge' => $delivery_charge ?? null,
                    'min_charge' => $addCharge,
                    'deposite_price' => $depositeprice,
                    'insurance_price' => $insuranceprice,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->product->productUpdate($productId, $productData);

                // Update Product Details Table
                foreach ($attributeId as $key => $val) {

                    if (empty($prev_product_details[$key])) {

                        $this->product->updateProductDetailsByProductId([$key], [
                            'product_id' => $productId,
                            'vendor_id' => $request->session()->get('vendor_id', null),
                            'product_attr_id' => $attributeId[$key],
                            'attribute_value' => $atributeValue[$key],
                            'attribute_value_unit_id' => $unitId[$key],
                            'updated_at' => date('y-m-d H:i:s'),
                        ]);
                    }
                }

                if ($productTypeId == 2) {
                    if (empty($priceAcc)) {
                        return JsonUtil::getResponse(false, "Price is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }
                    $this->product->updateProductPricingByProductId($productId, [
                        'product_id' => $productId,
                        'vendor_id' => $request->session()->get('vendor_id', null),
                        'pricing_plan_unit' => $planUnitAcc,
                        'price' => $priceAcc,
                        'currency' => $currency,
                        'updated_at' => date('y-m-d H:i:s'),
                    ]);
                } else {
                    foreach ($planUnit as $key => $val) {

                        if (empty($price[$key])) {
                            return JsonUtil::getResponse(false, $planUnit[$key] . " price is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                        } elseif (!RegexUtil::isFloat($price[$key])) {
                            return JsonUtil::getResponse(false, "Price accepts only numaric for " . $planUnit[$key], JsonUtil::$_UNPROCESSABLE_ENTITY);
                        }   

                        $this->product->updateProductPricingByProductId($prev_product_price[$key], [
                            'product_id' => $productId,
                            'vendor_id' => $request->session()->get('vendor_id', null),
                            'pricing_plan_unit' => $planUnit[$key],
                            'price' => $price[$key],
                            'currency' => $currency,
                            'updated_at' => date('y-m-d H:i:s'),
                        ]);
                    }
                }




                DB::commit();
                return JsonUtil::getResponse(true, "Product Updated successfully !", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                DB::rollBack();
                return JsonUtil::getResponse(false, $e->getMessage(), 500);
                return JsonUtil::serverError();
            }
        }
    }

    public function deleteProduct(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $productId = $request->get('productId') ?? '';
            if ($productId == "" || !RegexUtil::isNumeric($productId) || !$this->product->isProductIdValid($productId)) {
                return JsonUtil::getResponse(false, "Invalid Id...", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $isProductBooked = $this->booking->isProductAlreadyBooked($productId);
            // dd($isProductBooked);
            if ($isProductBooked == 0) {
                try {
                    $this->product->deleteProduct($productId);
                    return JsonUtil::getResponse(true, "Product deleted succssfully!", 200);
                } catch (Exception $e) {
                    return JsonUtil::getResponse(false, $e->getMessage(), 500);
                    return JsonUtil::serverError();
                }
            } else {
                return JsonUtil::getResponse(false, "You can't delete this product. It has been booked by user !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function activeProduct(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $productId = $request->get('product_id') ?? '';
            $status = $request->get('status') ?? '';

            if (empty($productId) || !$this->product->isProductIdValid($productId)) {
                return JsonUtil::getResponse(false, "Invalid ID", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($status == '0') {
                $s = 'deactivated';
            } else {
                $s = 'activated';
            }
            try {
                $this->product->productUpdate($productId, [
                    'is_active' => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                return JsonUtil::getResponse(true, "Product " . $s . " successfully !", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {

                return JsonUtil::serverError();
            }
        }
    }
}
