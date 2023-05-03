<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class PublicLoginCtlr extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function login(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {

            $goTo = $request->get('goto') ?? '';
            return view('public.login')->with([
                'goto' => $goTo
            ]);
        } elseif (HttpMethodUtil::isMethodPost()) {
            $phone = $request->get('phone') ?? '';
            $pwd = $request->get('password') ?? '';
            
            try {
                $userData = $this->user->getUserDataByPhone($phone);

                if ($userData == null) {
                    return JsonUtil::getResponse(false, 'Invalid phone number or password', JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                if (!password_verify($pwd, $userData->password)) {
                    return JsonUtil::getResponse(false, 'Invalid phone number or password', JsonUtil::$_UNPROCESSABLE_ENTITY);
                }

                if (!$this->user->isUserIsActive($phone)) {
                    return JsonUtil::getResponse(false, "Sorry ! Your Account has been suspend for some reason, please contact the admin ?", JsonUtil::$_BAD_REQUEST);
                }

                // return $userData;
                session()->put('user_id', $userData->id);
                session()->put('user_name', $userData->name);

                return JsonUtil::getResponse(true, 'Login successful', JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                return $e->getMessage();
                // return JsonUtil::serverError();
            }
        }
    }

    public function logOut(Request $request)
    {
        $request->session()->forget('user_id');
        $request->session()->forget('user_name');
        return redirect('login');
    }
}
