<?php

namespace App\Http\Middleware;

use Closure;

class AccessLevelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $access_level, $is_api)
    {
        if ((int)$request->user()->access_level_id !== (int)$access_level) {
            if ($is_api == 'true') {
                return response()->json('You are not allowed to do this action', 500);
            } else {
                return response()->view('restricted');
            }
        }

        return $next($request);
    }
}
