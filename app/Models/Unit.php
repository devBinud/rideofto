<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Unit extends Model
{
    use HasFactory;
    protected $unit = "master_unit";

    // -------------------Check-----------------------------------------------------

    public function isUnitIdValid($unitId)
    {
        return DB::table($this->unit)->where('id', $unitId)->count() > 0;
    }

    public function isUnitIsExistUnderVendor($unit)
    {
        return DB::table($this->unit)->where([['unit', $unit]])->count() > 0;
    }

    //-------------------------Read---------------------------------------------------

    public function getAllUnit($perPage = null)
    {
        $querry = DB::table($this->unit)->orderByDesc('id');
        if ($perPage == null) {
            return $querry->get();
        } else {
            return $querry->paginate($perPage);
        }
    }

    //-----------------ADD/UPDATE--------------------------------------------------

    public function addUnit(array $val)
    {
        return DB::table($this->unit)->insert($val);
    }

    public function updateUnit($unitId, array $val)
    {
        return DB::table($this->unit)->where('id', $unitId)->update($val);
    }


    //-------------------------------DELETE-----------------------------------------

    public function deleteUnit($unitId)
    {
        return DB::table($this->unit)->where('id', $unitId)->delete($unitId);
    }


}
