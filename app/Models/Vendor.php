<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendor extends Model
{
    use HasFactory;
    protected $table = "vendor";
    protected $vendorTiming = "vendor_timing";
    protected $blockDate = "vendor_block_date";
    protected $dateRange = "vendor_date_range";
    protected $vendorSettlement = "vendor_settlement";
    protected $vendorPaymentSettings = "master_vendor_payment_settings";

    // ------------Check--------------------------------------------------------

    public function isVendorIdValid($vendorId)
    {
        return DB::table($this->table)->where([['id', $vendorId], ['is_active', '1']])->count() > 0;
    }

    public function isVendorValid($vendorId)
    {
        return DB::table($this->table)->where('id', $vendorId)->count() > 0;
    }

    public function isVendorIsActive($phone)
    {
        return DB::table($this->table)->where([['store_phone', $phone], ['is_active', '1']])->count() > 0;
    }
    public function isVendorExists(string $vendorName)
    {
        return DB::table($this->table)->where('store_name', $vendorName)->count() > 0;
    }

    public function isPhoneNumberAlreadyExists($phone)
    {
        return DB::table($this->table)->where('store_phone', $phone)->count() > 0;
    }

    public function isPhoneNumberValid($phone)
    {
        return DB::table($this->table)->where('store_phone', $phone)->count() > 0;
    }
    public function isVendorNameAndIdMatched($vendorId, $vendorName)
    {
        return DB::table($this->table)->where([['id', $vendorId], ['store_name', $vendorName]])->count() > 0;
    }

    public function isVendorAlreadyHaveSchedule($vendorId)
    {
        return DB::table($this->vendorTiming)->where('vendor_id', $vendorId)->count() > 0;
    }

    public function isBlockDateIsAlreadyExists($vendorId,$date)
    {
       return DB::table($this->blockDate)->where([['vendor_id',$vendorId],['block_date',$date]])->count() > 0;
    }

    public function isDateRangeExistsOnCurrentAndFuture($vendorId)
    {
       return DB::table($this->blockDate)
       ->where('vendor_id',$vendorId)
       ->whereNotNull('start_date_range')
       ->whereRaw('start_date_range >= CURDATE() AND end_date_range > CURDATE()')
       ->count() > 0;
    }
    //------------------Read-----------------------------------------------

    public function getVendors($whereRaw = '1=?', $whereParam = [1], $orderByRaw = 'agreement.id DESC , vendor.id DESC', $paginate = false, $perPage = 10)
    {
        $querry = DB::table($this->table)
        ->select(
            'vendor.id',
            'vendor.store_name',
            'vendor.store_image',
            'vendor.store_phone',
            'vendor.store_email',
            'vendor.city_town_id',
            'vendor.postal_code',
            'vendor.address',
            'vendor.latitude',
            'vendor.longitude',
            'vendor.is_delivery_available',
            'vendor.max_delivery_distance',
            'vendor.is_active',
            'vendor.created_at',
            'vendor.created_by',
            'vendor.updated_at',
            'vendor.updated_by',
            'master_city_town.city_town',
            'master_region.region' ,

            'agreement.id as agreement_id',
            'agreement.agreement_name as agreement_name',
            'agreement.vendor_percentage as vendor_percentage',
            'agreement.created_at as agreement_created_at',
            'agreement.valid_from as agreement_valid_from',
            'agreement.valid_till as agreement_valid_till',
            'agreement.vendor_agree_at as vendor_agree_at',
            'agreement.status as agreement_status',
            'agreement.governed_by as governed_by',
        )
        ->leftJoin('master_city_town', 'master_city_town.id', '=', 'vendor.city_town_id')
        ->leftJoin('master_region', 'master_city_town.region_id', '=', 'master_region.id')
        ->leftJoin('vendor_agreement as agreement', 'agreement.vendor_id', '=', 'vendor.id')
        ->whereRaw($whereRaw, $whereParam)
        ->orderByRaw($orderByRaw)
        ->groupBy('vendor.id');

        if ($paginate) {
            return $querry->paginate($perPage);
        } else {
            return $querry->get();
        }
    }


    public function getAgreements($whereRaw = '1=?', $whereParam = [1], $paginate = true, $perPage = 30, $orderByRaw = 'agreement.id ASC')
    {
        $querry = DB::table('vendor_agreement as agreement')
        ->select(
            'agreement.*',
            'vendor.store_name',
            'vendor.store_image',
            'vendor.store_phone',
            'vendor.store_email',
            'vendor.city_town_id',
            'vendor.postal_code',
            'vendor.address',
            'vendor.latitude',
            'vendor.longitude',
            'vendor.is_delivery_available',
            'vendor.max_delivery_distance',
            'vendor.is_active as vendor_is_active',
        )
        ->leftJoin('vendor','vendor.id','agreement.vendor_id')
        ->whereRaw($whereRaw, $whereParam);

        if ($paginate) {
            return $querry->paginate($perPage);
        } else {
            return $querry->get();
        }
    }

    public function getAgreementsGroupByVendor($whereRaw = '1=?', $whereParam = [1], $paginate = true, $perPage = 30, $orderByRaw = 'agreement.id ASC')
    {
        $querry = DB::table('vendor_agreement as agreement')
        ->select(
            'agreement.*',
            'vendor.store_name',
            'vendor.store_image',
            'vendor.store_phone',
            'vendor.store_email',
            'vendor.city_town_id',
            'vendor.postal_code',
            'vendor.address',
            'vendor.latitude',
            'vendor.longitude',
            'vendor.is_delivery_available',
            'vendor.max_delivery_distance',
            'vendor.is_active as vendor_is_active',

            DB::raw('GROUP_CONCAT(agreement.id) as agreement_ids') ,
            DB::raw('GROUP_CONCAT(agreement.agreement_name) as agreement_agreement_names') ,
            DB::raw('GROUP_CONCAT(agreement.vendor_percentage) as agreement_vendor_percentages') ,
            DB::raw('GROUP_CONCAT(agreement.valid_from) as agreement_valid_froms') ,
            DB::raw('GROUP_CONCAT(agreement.valid_till) as agreement_valid_tills') ,
            DB::raw('GROUP_CONCAT(agreement.agreement_file) as agreement_files') ,
        )
        ->leftJoin('vendor','vendor.id','agreement.vendor_id')
        ->whereRaw($whereRaw, $whereParam)
        ->groupBy('vendor.id') ;

        if ($paginate) {
            return $querry->paginate($perPage);
        } else {
            return $querry->get();
        }
    }

    public function getAgreementById($agreementId)
    {
        return DB::table('vendor_agreement as agreement')
        ->select(
            'agreement.*',
            'vendor.store_name',
            'vendor.store_image',
            'vendor.store_phone',
            'vendor.store_email',
            'vendor.city_town_id',
            'vendor.postal_code',
            'vendor.address',
            'vendor.latitude',
            'vendor.longitude',
            'vendor.is_delivery_available',
            'vendor.max_delivery_distance',
            'vendor.is_active as vendor_is_active',
        )
        ->leftJoin('vendor','vendor.id','agreement.vendor_id')
        ->where('agreement.id',$agreementId)
        ->first() ;
    }

    public function getCurrentVendorAgreement($vendorId)
    {
        return DB::table('vendor_agreement')
        ->where([
            ['vendor_id',$vendorId],
            ['valid_from','<=',date('Y-m-d')],
            ['valid_till','>=',date('Y-m-d')]
        ])
        ->orderBy('id')
        ->first() ;
    }

    public function getAllvendorDetails($perPage = null)
    {
        $querry = DB::table($this->table)
            ->select(
                'vendor.id',
                'vendor.store_name',
                // 'vendor.username',
                'vendor.password',
                'vendor.store_image',
                'vendor.store_phone',
                'store_email',
                'vendor.city_town_id',
                'vendor.postal_code',
                'vendor.address',
                'vendor.latitude',
                'vendor.longitude',
                'vendor.is_delivery_available',
                'vendor.max_delivery_distance',
                'vendor.is_active',
                'vendor.created_at',
                'vendor.created_by',
                'vendor.updated_at',
                'vendor.updated_by',
                'master_city_town.city_town'
            )
            ->leftJoin('master_city_town', 'master_city_town.id', '=', 'vendor.city_town_id')
            ->orderByDesc('vendor.id')
            ->where('vendor.is_active', '1');

        if ($perPage == null) {
            return $querry->get();
        } else {
            return $querry->paginate($perPage);
        }
    }

    public function getVendorDetailsByVendorId($vendorId)
    {
        return DB::table($this->table)
        ->select(
            
            'vendor.id as vendor_id',
            'vendor.*',
            'master_city_town.city_town',
            'master_region.region',

            'vendor_timing.id as vendor_timing_id',
            'vendor_timing.monday_opening',
            'vendor_timing.monday_closing',
            'vendor_timing.tuesday_opening',
            'vendor_timing.tuesday_closing',
            'vendor_timing.wednesday_opening',
            'vendor_timing.wednesday_closing',
            'vendor_timing.thursday_opening',
            'vendor_timing.thursday_closing',
            'vendor_timing.friday_opening',
            'vendor_timing.friday_closing',
            'vendor_timing.saturday_opening',
            'vendor_timing.saturday_closing',
            'vendor_timing.sunday_opening',
            'vendor_timing.sunday_closing',

            'agreement.id as agreement_id',
            'agreement.agreement_name as agreement_name',
            'agreement.vendor_percentage as vendor_percentage',
            'agreement.created_at as agreement_created_at',
            'agreement.valid_from as agreement_valid_from',
            'agreement.valid_till as agreement_valid_till',
            'agreement.vendor_agree_at as vendor_agree_at',
            'agreement.status as agreement_status',
            'agreement.governed_by as governed_by',
        )
        ->leftJoin('master_city_town', 'master_city_town.id', '=', 'vendor.city_town_id')
        ->leftJoin('master_region', 'master_city_town.region_id', '=', 'master_region.id')
        ->leftJoin('vendor_timing', 'vendor_timing.vendor_id', '=', 'vendor.id')
        ->leftJoin('vendor_agreement as agreement', 'agreement.vendor_id', '=', 'vendor.id')
        ->where('vendor.id', $vendorId)
        ->orderByRaw('agreement.id DESC , vendor.id DESC')
        ->groupBy('vendor.id')
        ->first();
    }

    public function getVendorOrders($vendorId)
    {

        $q = "SELECT *,
             (SELECT GROUP_CONCAT(producta.product_name) FROM user_booking_details AS ubda LEFT JOIN product AS producta ON ubda.product_id = producta.id LEFT JOIN master_product_type AS mpta ON producta.product_type_id = mpta.id WHERE mpta.product_type = 'Accessories' AND ubda.booking_id = ub.id ) AS acc_prod,
             (SELECT GROUP_CONCAT(ubda.product_price) FROM user_booking_details AS ubda LEFT JOIN product AS producta ON ubda.product_id = producta.id LEFT JOIN master_product_type AS mpta ON producta.product_type_id = mpta.id WHERE mpta.product_type = 'Accessories' AND ubda.booking_id = ub.id ) AS acc_price , 
             (SELECT GROUP_CONCAT(ubda.currency) FROM user_booking_details AS ubda LEFT JOIN product AS producta ON ubda.product_id = producta.id LEFT JOIN master_product_type AS mpta ON producta.product_type_id = mpta.id WHERE mpta.product_type = 'Accessories' AND ubda.booking_id = ub.id ) AS acc_curency 
         FROM `user_booking_details` AS ubd 
         LEFT JOIN user_booking AS ub ON ubd.booking_id=ub.id 
         LEFT JOIN user ON ub.user_id=user.id 
         LEFT JOIN vendor_product_pricing AS vpp ON ub.pricing_plan_id=vpp.id 
         LEFT JOIN product ON ubd.product_id = product.id 
         LEFT JOIN master_product_type AS mpt ON product.product_type_id = mpt.id 
         where mpt.product_type = 'Cycle' AND ubd.vendor_id = '$vendorId'";


        return DB::select($q);
    }

    public function getPassword($phone)
    {
        return DB::table($this->table)->where('store_phone', $phone)->first('password')->password;
    }

    public function getVendorByPhone($phone)
    {
        return DB::table($this->table)->where([['store_phone', $phone], ['is_active', '1']])->first();
    }

    public function vendorTiming($vendorId)
    {
        return DB::table($this->vendorTiming)->where('vendor_id', $vendorId)->first();
    }

    public function getBlockDates($vendorId,$whereRaw = '1=?', $whereParam = [1],$perPage = null)
    {
        $q =  DB::table($this->blockDate)
        ->where('vendor_id',$vendorId)
        ->whereRaw($whereRaw, $whereParam);
        // ->orderByDesc('id');
        if($perPage == null){
            return $q->get();
        }else{
            return $q->orderbyDesc('id')->paginate($perPage);
        }
    }

    public function getAllFutureAndCurrentDatesFromDateRange($vendorId)
    {
       return DB::table($this->dateRange)
       ->select('dates')
       ->where('vendor_id',$vendorId)
       ->whereRaw('dates >= CURDATE()')
       ->get();
    }

    public function getVendorCurrentPaymentSettings()
    {
        return DB::table($this->vendorPaymentSettings)->first();
    }

    public function getVendorListWithPayment($whereRaw = '1=?', $whereParam = [1],$perPage = 20)
    {
        return DB::table($this->vendorSettlement)
        ->select(
            'vendor.id',
            'vendor.store_name',
            'vendor.store_image',
            'vendor.store_phone',
            'vendor.store_email',
            'vendor.city_town_id',
            'vendor.postal_code',
            'vendor.address',
            'vendor.latitude',
            'vendor.longitude',
            'vendor.is_delivery_available',
            'vendor.max_delivery_distance',
            'vendor.is_active',
            'master_city_town.city_town',
            'master_region.region' ,
            DB::raw('MAX(vendor_settlement.payment_date) as last_payment_date')
        )
        ->leftJoin('vendor','vendor_settlement.vendor_id','vendor.id')
        ->leftJoin('master_city_town', 'master_city_town.id', '=', 'vendor.city_town_id')
        ->leftJoin('master_region', 'master_city_town.region_id', '=', 'master_region.id')
        ->whereRaw($whereRaw, $whereParam)
        ->groupBy('vendor_settlement.vendor_id')
        ->orderByDesc('vendor_settlement.last_update')
        ->paginate($perPage);
    }

    public function getPaymentSettlementList($whereRaw = '1=?', $whereParam = [1],$paginate = true, $perPage = 20,$selectRaw=null)
    {
        $q= DB::table($this->vendorSettlement)
        ->select(
            'vendor_settlement.*',
            )
        ->whereRaw($whereRaw,$whereParam) ;


        if(!empty($selectRaw)){
            $q->selectRaw($selectRaw) ;
        }

        if($q){
            return $q->paginate($perPage) ;
        } else {
            return $q->get() ;
        }
    }

    
    //------------------Add/Update--------------------------------------------------

    public function addVendor(array $val)
    {
        return DB::table($this->table)->insert($val);
    }

    public function editVendor($vendorId, $val)
    {
        return DB::table($this->table)->where('id', $vendorId)->update($val);
    }

    public function updateSchedule($vendorId, $val)
    {
        return DB::table($this->vendorTiming)->where('vendor_id', $vendorId)->update($val);
    }

    public function addSchedule($val)
    {
        return DB::table($this->vendorTiming)->insert($val);
    }

    public function addBlockDates($val)
    {
       return DB::table($this->blockDate)->insert($val);
    }

    public function insertDatesFromRange($val)
    {
       return DB::table($this->dateRange)->insert($val);
    }

    public function addVendorAgreement(array $val)
    {
        return DB::table('vendor_agreement')->insertGetId($val);
    }

    public function updateVendorAgreement($vendorId,array $val)
    {
        return DB::table('vendor_agreement')->where('id',$vendorId)->update($val);
    }


    public function insertUpdateVendorSettlementAmount(int $vendorId,float $amount,int $vendorPercentage)
    {
        $queryResult = DB::select('call updateOrInsertVendorSettlementAmount(?, ?, ?)', [$vendorId,$amount,$vendorPercentage]);

        $result = collect($queryResult);

        return $result ;
    }

    //------------------Delete--------------------------------------------------

    public function deleteBlockDate($id)
    {
        return DB::table($this->blockDate)->where('id',$id)->delete();
    }
}
