<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Carbon\Carbon;
use App\Model\UsersForAutoMail;

class UserupdateMiddleware
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
        
        if (Auth::check()) {
            $au = Auth::user();
            $au->loggedin_at = Carbon::now();
            // $au->listForAutoMail()->firstOrCreate([]);
            $au->save();

            // $uam = UsersForAutoMail::whereDoesntHave('items', function ($query) {
            //         $query->where('created_at', '>', Carbon::now()->subDays(6));
            //     })
            //     ->has('user')
            //     ->where('type', 'match')
            //     ->where('subscribed', 1)
            //     ->first();
            //     if ($uam) 
            //     {
            //         $uam->user->automailSend($uam);
            //     }
        }

        return $next($request);
    }
}
