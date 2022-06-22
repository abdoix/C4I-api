<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AssignGuard
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next, $guard=null)
    {
        if($guard!=null){
            auth()->shouldUse($guard);// shoud you user guard/table
            try{
                //$user = auth()->user() ->authenticate($request);// check authenticted user
                JWTAuth::parseToken()->authenticate();
            }catch(TokenExpiredException $e){
                return $this->returnError("",'Unauthenticated user');
            }catch(JWTException $e){
                return $this->returnError("",'token_invalid '.$e->getMessage());
            }
        }
        return$next($request);
    }
}
