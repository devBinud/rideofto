<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Illuminate\Http\Request;

class UserMW
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
            if (!$request->session()->has('user_id')) {
                if (HttpMethodUtil::isMethodGet()) {
                    return redirect('/login');
                } else {
                    return JsonUtil::accessDenied();
                }
            }
    
            $request->merge([
                'user_id' => $request->session()->get('user_id', null),
            ]);
        return $next($request);
    }
}
