<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    use HasFactory;
    protected $table = 'user';

    //---------------Check-----------------------------------------------------
   
    public function isUserIdValid($userId)
    {
        return DB::table($this->table)->where('id',$userId)->count() > 0;
    }
    public function isPhoneNumberAvailable($phone)
    {
        return DB::table($this->table)->where('phone', $phone)->count() > 0;
    }

    public function isPhoneNumberAndIdMatch($userId,$phone)
    {
        return DB::table($this->table)->where([['id',$userId],['phone',$phone]])->count() > 0;
    }

    public function isUserIsActive($phone)
    {
        return DB::table($this->table)->where([['phone', $phone], ['is_active', '1']])->count() > 0;
    }

    // --------------------------Read---------------------------------------------------

    public function getUserDataByPhone($phone)
    {
        return DB::table($this->table)->where('phone', $phone)->first();
    }

    public function getUserByUserId($userId)
    {
        return DB::table($this->table)->where('id',$userId)->first();
    }

    public function getAllUser($whereRaw = '1=?', $whereParams = [1], $paginate = true, $perPage = 20)
    {
        $querry = DB::table($this->table)
            ->whereRaw($whereRaw, $whereParams)
            ->orderByDesc('id');
        if ($paginate) {
            return $querry->paginate($perPage);
        } else {
            return $querry->get();
        }
    }

    //----------------insert / Update-------------------------------------------

    public function addUser(array $val)
    {
        return DB::table($this->table)->insert($val);
    }

    public function updateUser($userId,$val)
    {
        return DB::table($this->table)->where('id',$userId)->update($val);
    }

    public function addReview(array $val)
    {
        return DB::table('user_review')->insert($val);
    }

  
}
