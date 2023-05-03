<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Unit;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use App\Utils\RegexUtil;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdmMasterCtlr extends Controller
{
    private $unit;
    private $product;
    public function __construct()
    {
        $this->unit = new Unit();
        $this->product = new Product();
    }
    public function index(Request $request)
    {
        $action = $request->get('action') ?? '';

        switch ($action) {
            case 'unit-master':
                return $this->unitMaster($request);
                break;
            case 'product-category':
                return $this->productCategory($request);
                break;
            case 'edit-category':
                return $this->editCategory($request);
                break;
            case 'delete-category':
                return $this->deleteCategory($request);
                break;
            case 'product-attribute':
                return $this->productAttribute($request);
                break;
            case 'edit-product-attribute':
                return $this->editProductAttribute($request);
                break;
            case 'delete-product-attr':
                return $this->deleteProductAttr($request);
                break;
            default:
                return abort(404);
                break;
        }
    }

    public function unitMaster(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $units = $this->unit->getAllUnit(20);
            return view('admin.master.unit-master')->with([
                'currentPage' => 'unit',
                'unit' => $units,
                'sn' => ($units->currentPage() - 1) * $units->perPage(),
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $type = $request->get('type') ?? '';
            // dd($type);
            $unit = $request->get('unit') ?? '';
            $unitId = $request->get('unitId') ?? '';

            switch ($type) {
                case 'add':
                    if (empty($unit)) {
                        return JsonUtil::getResponse(false, "Unit is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    } elseif ($this->unit->isUnitIsExistUnderVendor($unit)) {
                        return JsonUtil::getResponse(false, "Unit is already exists!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }
                    try {
                        $this->unit->addUnit([
                            'unit' => $unit,
                        ]);

                        return JsonUtil::getResponse(true, "Unit added successfully!", JsonUtil::$_STATUS_OK);
                    } catch (Exception $e) {
                        return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }
                    break;
                case 'delete-unit':
                    if ($unitId == "" || !RegexUtil::isNumeric($unitId) || !$this->unit->isUnitIdValid($unitId)) {
                        return JsonUtil::getResponse(false, "Invalid Id!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }

                    $isUse = $this->product->isUnitALreadyUse($unitId);

                    if ($isUse == 0) {
                        try {
                            $this->unit->deleteUnit($unitId);
                            return JsonUtil::getResponse(true, "Unit deleted succssfully!", 200);
                        } catch (Exception $e) {
                            JsonUtil::serverError();
                        }
                    } else {
                        return JsonUtil::getResponse(false, "You can't delete this data. This data has been used!", 200);
                    }
                    break;
                default:

                    if ($unitId == "" || !RegexUtil::isNumeric($unitId) || !$this->unit->isUnitIdValid($unitId)) {
                        return JsonUtil::getResponse(false, "Invalid Id!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }

                    if (empty($unit)) {
                        return JsonUtil::getResponse(false, "Unit is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    } elseif ($this->unit->isUnitIsExistUnderVendor($unit)) {
                        return JsonUtil::getResponse(false, "Unit is already exists!", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }

                    try {
                        $this->unit->updateUnit($unitId, [
                            'unit' => $unit,
                        ]);
                        return JsonUtil::getResponse(true, "Unit updated successfully!", JsonUtil::$_STATUS_OK);
                    } catch (Exception $e) {
                        return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }

                    break;
            }
        }
    }

    public function productCategory(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $productCat = $this->product->getAllProductCategory($whereRaw = '1=?', $whereParams = [1], 20);
            return view('admin.master.view-product-category')->with([
                'currentPage' => 'product',
                'products' => $this->product->getProductTypes(),
                'productCategory' => $productCat,
                'sn' => ($productCat->currentPage() - 1) * $productCat->perPage(),
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $productType = $request->get('productType') ?? '';
            $category = $request->get('category') ?? '';
            $categorySlug = $request->get('categorySlug') ?? '';

            if (empty($productType)) {
                return JsonUtil::getResponse(false, "Please select product type!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($category)) {
                return JsonUtil::getResponse(false, "Category is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($category) > 100) {
                return JsonUtil::getResponse(false, "Category can't be more than 100 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($this->product->categorySlugIsAvliable($categorySlug)) {
                return JsonUtil::getResponse(false, "This Category Slug is alredy Exists. Please Change The Slug !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($this->product->isCategoryExistsUnderProductType($productType, $category)) {
                return JsonUtil::getResponse(false, "The category is already exist under the product type!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try {

                $this->product->addCategory([
                    'product_type_id' => $productType,
                    'product_category' => $category,
                    'category_slug' => $categorySlug,
                ]);
                return JsonUtil::getResponse(true, "Product category added successfully!", 200);
            } catch (Exception $e) {
                // return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function editCategory(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $categoryId = $request->get('id') ?? '';
            if (!RegexUtil::isNumeric($categoryId) || !$this->product->isCategoryIdValid($categoryId)) {
                return JsonUtil::getResponse(false, "Invalid ID...", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            if (RegexUtil::isNumeric($categoryId)) {
                $whereRaw = "master_product_category.id=?";
                $whereParams = [$categoryId];
                $v = view('admin.master.partials.edit-category', [
                    'products' => $this->product->getProductTypes(),
                    'singleCategory' => $this->product->getAllProductCategory($whereRaw, $whereParams)[0],
                ])->render();
                return response()->json(['html' => $v], 200);
            }
        } elseif (HttpMethodUtil::isMethodPost()) {
            $categoryId = $request->get('id') ?? '';
            if (!RegexUtil::isNumeric($categoryId) || !$this->product->isCategoryIdValid($categoryId)) {
                return JsonUtil::getResponse(false, "Invalid ID...", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            $editproductType = $request->get('editproductType') ?? '';
            $editcategory = $request->get('editcategory') ?? '';
            $editcategorySlug = $request->get('editcategorySlug') ?? '';

            try {

                $this->product->updateCategory($categoryId, [
                    'product_type_id' => $editproductType,
                    'product_category' => $editcategory,
                    'category_slug' => $editcategorySlug
                ]);
                return JsonUtil::getResponse(true, "Category updated successfully !", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, "Something went wrong !", JsonUtil::$_BAD_REQUEST);
            }
        }
    }

    public function deleteCategory(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $categoryId = $request->get('categoryId') ?? '';
            if (!RegexUtil::isNumeric($categoryId) || !$this->product->isCategoryIdValid($categoryId)) {
                return JsonUtil::getResponse(false, "Invalid ID...", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $isUse = $this->product->isProductCategoryAlredyUse($categoryId);
            // dd($isUse);
            if ($isUse == 0) {
                try {
                    $this->product->deleteCategory($categoryId);
                    return JsonUtil::getResponse(true, "Category deleted succssfully!", 200);
                } catch (Exception $e) {
                    JsonUtil::serverError();
                }
            } else {
                return JsonUtil::getResponse(false, "You can't delete this data. This data has been used!", 200);
            }
        }
    }

    public function productAttribute(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $productAttr = $this->product->getAllProductAttribute($whereRaw = '1=?', $whereParams = [1], 20);

            return view('admin.master.product-attribute')->with([
                'currentPage' => 'productAttr',
                'products' => $this->product->getProductTypes(),
                'productsAttr' => $productAttr,
                'sn' => ($productAttr->currentPage() - 1) * $productAttr->perPage(),
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $productType = $request->get('productType') ?? '';
            $attrName = $request->get('attrName') ?? '';

            if (empty($productType)) {
                return JsonUtil::getResponse(false, "Please select product type!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($attrName)) {
                return JsonUtil::getResponse(false, "Attribute name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($attrName) > 100) {
                return JsonUtil::getResponse(false, "Attribute can't be more than 100 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($this->product->isProductAttrExistForProductType($productType, $attrName)) {
                return JsonUtil::getResponse(false, "This attribute is already exist for the product type!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try {
                $this->product->addProductAttribute([
                    'product_attr_name' => $attrName,
                    'product_type_id' => $productType,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by_admin' => $request->session()->get('admin_id'),
                ]);
                return JsonUtil::getResponse(true, "Product attribute added successfully!", 200);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, $e->getMessage(), JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function editProductAttribute(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            $attrId = $request->get('id') ?? '';
            if (!RegexUtil::isNumeric($attrId) || !$this->product->isProductAttrIdValid($attrId)) {
                return JsonUtil::getResponse(false, "Invalid ID...", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }
            $whereRaw = "pa.id=?";
            $whereParams = [$attrId];
           
            $v = view('admin.master.partials.edit-product-attribute', [
                'products' => $this->product->getProductTypes(),
                'singleAttr' => $this->product->getAllProductAttribute($whereRaw,$whereParams)[0],
            ])->render();
            return response()->json(['html' => $v], 200);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $attrId = $request->get('id') ?? '';
            if (!RegexUtil::isNumeric($attrId) || !$this->product->isProductAttrIdValid($attrId)) {
                return JsonUtil::getResponse(false, "Invalid ID...", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $productType = $request->get('editproductType') ?? '';
            $attrName = $request->get('editattrName') ?? '';

            if (empty($productType)) {
                return JsonUtil::getResponse(false, "Please select product type!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($attrName)) {
                return JsonUtil::getResponse(false, "Attribute name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($attrName) > 100) {
                return JsonUtil::getResponse(false, "Attribute can't be more than 100 characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if ($this->product->isProductAttrExistForProductType($productType, $attrName)) {
                return JsonUtil::getResponse(false, "This attribute is already exist for the product type!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try {

                $this->product->updateProductAtrr($attrId, [
                    'product_attr_name' => $attrName,
                    'product_type_id' => $productType,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by_admin' => $request->session()->get('admin_id'),
                ]);

                return JsonUtil::getResponse(true, "Product attribute updated successfully!", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::getResponse(false, "Something went wrong !", JsonUtil::$_BAD_REQUEST);
            }
        }
    }

    public function deleteProductAttr(Request $request)
    {
        if (HttpMethodUtil::isMethodPost()) {
            $attrId = $request->get('attrId') ?? '';
            if ($attrId == "" || !RegexUtil::isNumeric($attrId) || !$this->product->isProductAttrIdValid($attrId)) {
                return JsonUtil::getResponse(false, "Invalid Id!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $isUse = $this->product->isProductAttrAlredtUse($attrId);
            if ($isUse == 0) {
                try {
                    $this->product->deleteProductAttr($attrId);
                    return JsonUtil::getResponse(true, "Product attribute deleted successfully !", JsonUtil::$_STATUS_OK);
                } catch (Exception $e) {
                    return JsonUtil::serverError();
                }
            } else {
                return JsonUtil::getResponse(false, "You can't delete this data. This data has been used!", 200);
            }
        } else {
            return JsonUtil::getResponse(false, "Something went wrong !", JsonUtil::$_BAD_REQUEST);
        }
    }
}
