<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class VerifyDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sha1UserKey = sha1(auth()->user()->getKey());
        $shaUserAgent = sha1($request->server('HTTP_USER_AGENT'));

        if (!Cookie::has($sha1UserKey) || !hash_equals($shaUserAgent, Cookie::get($sha1UserKey))) {
            return redirect()->route('register.device');
        }

        return $next($request);
    }
}
