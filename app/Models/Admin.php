<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $city = 'master_city_town';

    /*
    -----------------------------------
    CHECK
    -----------------------------------
    */

    public function isPhoneNumberValid($phone)
    {
        return DB::table($this->table)->where('phone', $phone)->count() > 0;
    }

    /*
    -----------------------------------
    READ
    -----------------------------------
    */

    public function getPassword($phone)
    {
        return DB::table($this->table)->where('phone', $phone)->first('password')->password;
    }

    public function getAdminByPhone($phone)
    {
        return DB::table($this->table)->where('phone', $phone)->first();
    }

    public function getCityAll(){
        return DB::table($this->city)->orderBy('city_town')->get();
    }
}
