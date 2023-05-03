<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Discount extends Model
{
    use HasFactory;
    protected $discount = "vendor_product_discount";


    //-----------------Check------------------------------------------------------------------
    public function isDiscountIdValid($discountId)
    {
        return DB::table($this->discount)->where('id', $discountId)->count() > 0;
    }

    //-----------------Read---------------------------------------------------------------
  


    public function getDiscountList($vendorId, $perPage = null)
    {
        $querry = DB::table($this->discount . ' as d')
            ->select(
                'd.id',
                'd.discount_type',
                'd.discount',
                'd.discount_product_or_category',
                'd.starting_from',
                'd.valid_till',
                'd.is_active',
                'mpc.product_category',
                'product.product_name',
            )
            ->leftJoin('master_product_category as mpc', 'mpc.id', 'd.product_cat_ids')
            ->leftJoin('product', 'product.id', 'd.product_ids')
            ->where('d.vendor_id', $vendorId)
            ->orderByDesc('d.id');
        if ($perPage == null) {
            return $querry->get();
        } else {
            return $querry->paginate($perPage);
        }
    }

    public function getDiscount($productId ,$categoryIds)
    {
        $q = "SELECT * FROM vendor_product_discount where ( FIND_IN_SET($productId,product_ids) OR product_cat_ids LIKE $categoryIds ) AND valid_till >= NOW() AND is_active = '1' ORDER BY id DESC  "  ;

        return DB::select($q) ;
    }

    public function getDiscountById($discountId)
    {
        return DB::table($this->discount . ' as d')
            ->select(
                'd.id',
                'd.product_cat_ids',
                'd.product_ids',
                'd.discount_type',
                'd.discount',
                'd.discount_product_or_category',
                'd.starting_from',
                'd.valid_till',
                'd.is_active',
                'mpc.product_category',
                'product.product_name',
            )
            ->leftJoin('master_product_category as mpc', 'mpc.id', 'd.product_cat_ids')
            ->leftJoin('product', 'product.id', 'd.product_ids')
            ->where('d.id', $discountId)
            ->orderByDesc('d.id')
            ->first();
    }


    //------------------Add Update/Delete--------------------------------------

    public function insertDiscount($values)
    {
        return DB::table($this->discount)->insertGetId($values);
    }

    public function discountUpdate($discountId, $val)
    {
        return DB::table($this->discount)->where('id', $discountId)->update($val);
    }

    public function deleteDiscount($id)
    {
        return DB::table($this->discount)->where('id', $id)->delete($id);
    }
}
