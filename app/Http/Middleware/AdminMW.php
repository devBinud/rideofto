<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Illuminate\Http\Request;

class AdminMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $adminId = $request->session()->get('admin_id', '');

        if ($adminId == '' || $adminId == null) {
            
            if (HttpMethodUtil::isMethodGet()) {
                return redirect('admin/login');
            } else {
                return JsonUtil::accessDenied();
            }
        }

        return $next($request);
    }
}
