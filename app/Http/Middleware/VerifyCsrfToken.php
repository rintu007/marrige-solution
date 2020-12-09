<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'https://www.bridegroombd.com/payto/payment/gateway/callback',
        'http://bgbd.oo/payto/payment/gateway/callback'
    ];
}