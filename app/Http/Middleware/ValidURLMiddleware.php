<?php

namespace App\Http\Middleware;

use App\CustomResponses;
use Closure;
use Log;
class ValidURLMiddleware
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
        $URI = $request->getRequestUri();
        Log::info("1) => Inside Handle ".$URI);

        if(preg_match("/todos/", $URI)){
            Log::info("1) => Inside Handle prefix matched ".$URI);
            return $next($request);
        }

        Log::info("returned from Handler");
        return CustomResponses::getBadRequest();


    }
}
