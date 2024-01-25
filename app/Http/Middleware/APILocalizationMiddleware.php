<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class APILocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $local = ($request->hasHeader('locale')) ? (strlen($request->header('locale')) > 0 ?
            $request->header('locale') : 'ar') : 'ar';
        if ($request->get('locale')) {
            $local = $request->get('locale');
        }
        if (Session::has('locale')) {
            $local = Session::get('locale');
        }
        Session::put($local);
        App::setLocale($local);
        return $next($request);
    }
}