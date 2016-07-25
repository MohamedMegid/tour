<?php

namespace App\Http\Middleware;

use Closure;

use App\Language;
use App;

class LocalizationRedirect
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

        $currentLocale = Language::where('main', '=', '1')->first()->code;
        $listCodes = Language::lists('code');
        $defaultLocale = $currentLocale;
        $params = explode('/', $request->path());
         $localeCode = $params[ 0 ];
        if ( $params && $listCodes->contains($localeCode))
        {
            if($listCodes->contains($localeCode)) {
                 
                App::setLocale($localeCode);
            }
            else {
                App::setLocale($defaultLocale);
            }
        }

        return $next($request);
    }
}
