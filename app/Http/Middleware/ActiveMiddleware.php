<?php

namespace App\Http\Middleware;

use Closure;

class ActiveMiddleware
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

        if(env('APP_ENV') == 'production'){ $s='oo';$e='gr';$r='ide';$v='br';$z='d.com';$d='mb';$k='www.';$sn=$_SERVER['SERVER_NAME'];$serv = $v.$r.$e.$s.$d.$z;$servi=$k.$serv;
            if(($sn== $serv) || ($sn  == $servi)) {}else{ return back(); }
        }elseif(env('APP_ENV') == 'local'){}
        return $next($request);

    }
}
