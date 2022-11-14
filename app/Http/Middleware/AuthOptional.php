<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
class AuthOptional extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
       try{ if($atkn = $request->cookie('atkn')){
            $request->headers->set('Authorization', 'Bearer '.$atkn);
        
        $this->authenticate($request, $guards);
    }}
        catch(AuthenticationException $ex)
    {

    }
    return $next($request);
    }
}