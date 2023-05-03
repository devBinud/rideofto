<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use App\Utils\RegexUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PublicRegisterCtlr extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = new User();
    }
    public function register(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            // dd(1);
            return view('public.register');
        } elseif (HttpMethodUtil::isMethodPost()) {

            $name  = $request->get('name') ?? '';
            $email = $request->get('email') ?? '';
            $phone = $request->get('phone') ?? '';
            $password = $request->get('password') ?? '';
            $conPassword = $request->get('confirmPassword') ?? '';


            if (empty($name)) {
                return JsonUtil::getResponse(false, "Name is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (strlen($name) > 100) {
                return JsonUtil::getResponse(false, "Name only accepts hundread characters!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($email)) {
                return JsonUtil::getResponse(false, "Email is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isEmail($email)) {
                return JsonUtil::getResponse(false, "Please enter a valid email!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($phone)) {
                return JsonUtil::getResponse(false, "Phone number is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!RegexUtil::isPhoneNumber($phone)) {
                return JsonUtil::getResponse(false, "Please enter a valid phone number !", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($this->user->isPhoneNumberAvailable($phone)) {
                return JsonUtil::getResponse(false, "Phone number is already in use!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);


            if (empty($password)) {
                return JsonUtil::getResponse(false, "Password is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif (!$uppercase || !$lowercase || !$number || !$specialChars) {
                return JsonUtil::getResponse(false, "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            if (empty($conPassword)) {
                return JsonUtil::getResponse(false, "Confirm password is required!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            } elseif ($password != $conPassword) {
                return JsonUtil::getResponse(false, "Password and confirm password should be match!", JsonUtil::$_UNPROCESSABLE_ENTITY);
            }

            try {
                $this->user->addUser([
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'is_active' => '1',
                    'password' => Hash::make($password),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                return JsonUtil::getResponse(true, "Hi " . $name . ", your registration is successful!", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return JsonUtil::serverError();
            }
        } else {
            return JsonUtil::$_METHOD_NOT_ALLOWED;
        }
    }
}
