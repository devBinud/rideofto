<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $productType = 'master_product_type';
    protected $productCategory = "master_product_category";
    protected $productAttribute = "master_product_attr";
    protected $product = "product";
    protected $productDetails = "product_details";
    protected $productPricing = 'vendor_product_pricing';


    //---------------------Check---------------------------------------------------------

    public function isUnitALreadyUse($id)
    {
        return DB::table($this->productDetails)->where('attribute_value_unit_id', $id)->count() > 0;
    }

    public function categorySlugIsAvliable($slug)
    {
        return DB::table($this->productCategory)->where('category_slug', $slug)->count() > 0;
    }

    public function isCategoryExistsUnderProductType($productType, $cat)
    {
        return DB::table($this->productCategory)->where([['product_type_id', $productType], ['product_category', $cat]])->count() > 0;
    }

    public function isCategoryIdValid($categoryId)
    {
        return DB::table($this->productCategory)->where('id', $categoryId)->count() > 0;
    }

    public function isProductCategoryAlredyUse($id)
    {
        return DB::table($this->product)->where('product_category_ids', $id)->count() > 0;
    }

    public function isProductAttrExistForProductType($productType,$attrName)
    {
        return DB::table($this->productAttribute)
        ->where([['product_type_id',$productType],['product_attr_name',$attrName]])->count() > 0;
    }

    public function isProductAttrIdValid($id)
    {
        return DB::table($this->productAttribute)->where('id', $id)->count() > 0;
    }

    public function isProductAttrAlredtUse($id)
    {
        return DB::table($this->productDetails)->where('product_attr_id', $id)->count() > 0;
    }

    
    public function productSlugIsAvliable($slug)
    {
        return DB::table($this->product)->where('product_slug', $slug)->count() > 0;
    }

    public function isProductIdValid($productId)
    {
        return DB::table($this->product)->where('id', $productId)->count() > 0;
    }

    public function isProductActiveBySlug($slug)
    {
        return DB::table($this->product)->where([['product_slug',$slug],['is_active','1']])->count() > 0;
    }

    public function isAccessoriesHavePrice($vendorId,$productId)
    {
       return DB::table($this->productPricing)->where([['vendor_id',$vendorId],['product_id',$productId]])
       ->where('price',0)->count() > 0;
    }

   public function isproductIsAccessories($productId)
   {
    return DB::table($this->product)->where([['id',$productId],['product_type_id','2']])->count() > 0;
   }

    //--------------------Read-----------------------------------------------------------


    public function getCategoryByCategoryId($catId)
    {
        return DB::table($this->productCategory)->where('id', $catId)->first();
    }

    public function getAccessoriesById($id)
    {
        return DB::table($this->product)->where('id', $id)->first();
    }

    public function getVendorProductPriceById($vendorId, $productId)
    {
        return DB::table($this->productPricing)->where([['vendor_id', $vendorId], ['product_id', $productId]])
            ->get();
    }

    public function getProductTypes()
    {
        return DB::table($this->productType)->get();
    }

    public function getProductCatByProductTypeId()
    {
        return DB::table($this->productCategory)->orderByDesc('id')->get();
    }

    public function getAllProductCategory($whereRaw = '1=?', $whereParams = [1], $perPage = null)
    {
        $querry = DB::table('master_product_category')
            ->select(
                'master_product_category.id as category_id',
                'master_product_category.product_type_id',
                'master_product_category.product_category',
                'master_product_category.category_slug',
                'master_product_type.product_type'
            )
            ->leftJoin('master_product_type', 'master_product_type.id', '=', 'master_product_category.product_type_id')
            ->whereRaw($whereRaw, $whereParams)
            ->orderByDesc('master_product_category.id');
        if ($perPage == null) {
            return $querry->get();
        } else {
            return $querry->paginate($perPage);
        }
    }

    public function getAllProductAttribute($whereRaw = '1=?', $whereParams = [1],$perPage = null)
    {
        $querry  = DB::table($this->productAttribute . ' as pa')
            ->select(
                'pa.id',
                'pa.product_attr_name',
                'pa.product_type_id',
                'pa.created_at',
                'pt.product_type'
            )
            ->leftJoin('master_product_type as pt', 'pt.id', '=', 'pa.product_type_id')
            ->whereRaw($whereRaw, $whereParams)
            ->orderByDesc('pa.id');
        if ($perPage == null) {
            return $querry->get();
        } else {
            return $querry->paginate($perPage);
        }
    }

    public function getAllProductsPublic($whereRaw = '1=?', $whereParams = [1], $paginate = true, $perPage = 20)
    {
        $querry = DB::table($this->product . ' as p')
            ->select(
                'p.id',
                'p.is_active',
                'p.vendor_id',
                'p.product_type_id',
                'p.product_category_ids',
                'p.product_name',
                'p.product_slug',
                'p.product_description',
                'p.product_thumbnail',
                'p.product_images',
                'p.initial_stock',
                'p.remaining_stock',
                'pt.product_type',
                DB::raw("GROUP_CONCAT(pc.product_category) as categories")
            )
            ->leftJoin('master_product_type as pt', 'pt.id', '=', 'p.product_type_id')
            ->leftJoin('master_product_category as pc', DB::raw('FIND_IN_SET(pc.id, p.product_category_ids)'), '>', DB::raw('0'))
            ->where('p.is_active', '1')
            ->whereRaw($whereRaw, $whereParams)
            ->orderByDesc('p.id')
            ->groupBy('p.id');
        if ($paginate) {
            return $querry->paginate($perPage);
        } else {
            return $querry->get();
        }
    }

    public function getProductDetailsByProductSlug($slug)
    {
        return DB::table($this->product . ' as p')
            ->select(
                'p.id',
                'p.vendor_id',
                'p.product_type_id',
                'p.product_category_ids',
                'mpc.product_category',
                'p.product_name',
                'p.product_description',
                'p.product_thumbnail',
                'p.product_images',
                'p.initial_stock',
                'p.remaining_stock',
                'pt.product_type',
                'vpp.pricing_plan_value',
                'vpp.pricing_plan_unit',
                'vpp.price',
                'vpp.currency',
                'vpp.addn_charge',
                'vendor.address',
                'vendor.store_name'
            )
            ->leftJoin('master_product_type as pt', 'pt.id', '=', 'p.product_type_id')
            ->leftJoin('vendor_product_pricing as vpp', 'vpp.product_id', 'p.id')
            ->leftJoin('vendor', 'vendor.id', 'p.vendor_id')
            ->leftJoin('master_product_category as mpc', 'mpc.id', 'p.product_category_ids')
            ->where('p.product_slug', $slug)
            ->orderByDesc('p.id')
            ->first();
    }

    public function getProductDetailsByAttrProductSlug($slug)
    {
        return DB::table($this->product . ' as p')
            ->select(
                'p.id',
                'p.vendor_id',
                'p.product_type_id',
                'p.product_category_ids',
                'mpc.product_category',
                'p.product_name',
                'p.product_description',
                'p.product_thumbnail',
                'p.product_images',
                'p.initial_stock',
                'p.remaining_stock',
                'pt.product_type',
                'vpp.id as pricingPlanId',
                'vpp.pricing_plan_value',
                'vpp.pricing_plan_unit',
                'vpp.price',
                'vpp.currency',
                'vpp.addn_charge'
            )
            ->leftJoin('master_product_type as pt', 'pt.id', '=', 'p.product_type_id')
            ->leftJoin('vendor_product_pricing as vpp', 'vpp.product_id', 'p.id')
            ->leftJoin('master_product_category as mpc', 'mpc.id', 'p.product_category_ids')
            ->where('p.product_slug', $slug)
            ->orderByDesc('p.id')
            ->get();
    }

    public function getAllProductAttributeByVendorId($vendorId)
    {
        return DB::table($this->product . ' as  p')
            ->select(
                'p.*',
                'vpp.pricing_plan_value',
                'vpp.pricing_plan_unit',
                'vpp.price',
                'vpp.currency'
            )
            ->leftJoin('vendor_product_pricing as vpp', 'vpp.product_id', 'p.id')
            ->where([['p.product_type_id', 2], ['p.vendor_id', $vendorId],['p.is_active','1']])->get();
    }

    public function getProductByProductId($vendorId, $productId)
    {
        return DB::table($this->product . ' as p')
            ->select(
                'p.id',
                'p.vendor_id',
                'p.product_type_id',
                'p.product_category_ids',
                'p.product_name',
                'p.related_accessories',
                'p.product_slug',
                'p.product_description',
                'p.product_thumbnail',
                'p.product_images',
                'p.deposite_price',
                'p.insurance_price',
                'p.initial_stock',
                'p.remaining_stock',
                'p.related_accessories',
                'p.is_home_delivery',
                'p.max_delivery_distance',
                'p.delivery_charge',
                'p.min_charge',
                'pt.product_type',
                'vpp.currency',
                'vpp.pricing_plan_unit',
                'vpp.price',
                'vpp.addn_charge',
                'pd.attribute_value',
                'mpa.product_attr_name',
                'mu.unit',
            )
            ->leftJoin('master_product_type as pt', 'pt.id', '=', 'p.product_type_id')
            ->leftJoin('vendor_product_pricing as vpp', 'vpp.product_id', 'p.id')
            ->leftJoin('product_details as pd', 'pd.product_id', 'p.id')
            ->leftJoin('master_product_attr as mpa', 'mpa.id', 'pd.product_attr_id')
            ->leftJoin('master_unit as mu', 'mu.id', 'pd.attribute_value_unit_id')
            ->where([['p.vendor_id', $vendorId], ['p.id', $productId]])
            ->first();
    }

    public function getProductDetailsByProductId($vendorId, $productId)
    {
        return DB::table($this->productDetails . ' as pd')
            ->select(
                'pd.id',
                'pd.product_id',
                'pd.vendor_id',
                'pd.product_attr_id',
                'pd.attribute_value',
                'pd.attribute_value_unit_id',
                'mpa.product_attr_name',
                'mu.unit',
            )
            ->leftJoin('master_product_attr as mpa', 'mpa.id', 'pd.product_attr_id')
            ->leftJoin('master_unit as mu', 'mu.id', 'pd.attribute_value_unit_id')
            ->where([['pd.vendor_id', $vendorId], ['pd.product_id', $productId]])
            ->get();
    }

    public function vendorProductPricing($vendorId, $productId)
    {
        return DB::table($this->productPricing . ' as pp')
            ->select(
                'pp.id',
                'pp.product_id',
                'pp.vendor_id',
                'pp.pricing_plan_unit',
                'pp.price',
                'pp.addn_charge',
            )
            ->where([['pp.vendor_id', $vendorId], ['pp.product_id', $productId]])
            ->get();
    }

    public function getBookingPriceByPricingPlaneId($pricePlaneId)
    {
        return DB::table($this->productPricing)->where('id', $pricePlaneId)->first();
    }

    public function getProductCategories()
    {
        return DB::table($this->productCategory)->get();
    }

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

    public function getReviewByVendorId($vendorId, $perPage, $status = null)
    {
        $querry = DB::table('user_review as ur')
            ->select(
                'ub.id',
                'ub.vendor_id',
                'v.store_name',
                'v.address',
                'ub.user_id',
                'ub.product_id',
                'pd.product_name',
                'pd.product_images',
                'pd.product_thumbnail',
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
                'ur.ratings' ,
                'ur.review' ,
                'ur.id as review_id',
                'ur.created_at as review_created_at'

            )
            ->leftJoin('user_booking as ub', 'ub.id', '=', 'ur.booking_id')
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

    public function getReviewNRatings($whereRaw = '1=?',$whereParams = [1] ,  $paginate = false , $perPage = 20 , $orderByRaw = 'ub.id DESC')
    {
        $querry = DB::table('user_review as ur')
            ->select(
                'ub.id',
                'ub.vendor_id',
                'v.store_name',
                'v.address',
                'ub.user_id',
                'ub.product_id',
                'pd.product_name',
                'pd.product_images',
                'pd.product_thumbnail',
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
                'ur.ratings' ,
                'ur.review' ,
                'ur.id as review_id',
                'ur.created_at as review_created_at'

            )
            ->leftJoin('user_booking as ub', 'ub.id', '=', 'ur.booking_id')
            ->leftJoin('vendor as v', 'v.id', '=', 'ub.vendor_id')
            ->leftJoin('user as u', 'u.id', '=', 'ub.user_id')
            ->leftJoin('vendor_product_pricing as p', 'p.id', '=', 'ub.pricing_plan_id')
            ->leftJoin('product as pd', 'pd.id', '=', 'ub.product_id')

            ->whereRaw($whereRaw,$whereParams) 
            ->orderByRaw($orderByRaw) ;

            if($paginate){
                return $querry->paginate($perPage) ;
            } else {
                return $querry->get() ;
            }
            
    }

    //-----------------------Add/Delete---------------------------------------------

    public function addCategory(array $val)
    {
        return DB::table($this->productCategory)->insert($val);
    }

    public function addProductAttribute(array $val)
    {
        return DB::table($this->productAttribute)->insert($val);
    }

    public function addProduct(array $val)
    {
        return DB::table($this->product)->insertGetId($val);
    }
    public function addProductDetails(array $val)
    {
        return DB::table($this->productDetails)->insert($val);
    }

    public function addProductPricing(array $val)
    {
        return DB::table($this->productPricing)->insert($val);
    }

    public function updateProductAtrr($id, $values)
    {
        return DB::table($this->productAttribute)->where('id', $id)->update($values);
    }

    public function updateCategory($id, $values)
    {
        return DB::table($this->productCategory)->where('id', $id)->update($values);
    }

    public function productUpdate($id, $values)
    {
        return DB::table($this->product)->where('id', $id)->update($values);
    }

    public function deleteCategory($categoryId)
    {
        return DB::table($this->productCategory)->where('id', $categoryId)->delete($categoryId);
    }

    public function deleteProductAttr($id)
    {
        return DB::table($this->productAttribute)->where('id', $id)->delete($id);
    }
    public function deleteProduct($id)
    {
        return DB::table($this->product)->where('id', $id)->delete();
    }

    public function updateProductDetailsByProductId($productId, $values)
    {
        return DB::table($this->productDetails)->where('product_id', $productId)->update($values);
    }

    public function updateProductPricingByProductId($productId, $values)
    {
        return DB::table($this->productPricing)->where('product_id', $productId)->update($values);
    }

}
