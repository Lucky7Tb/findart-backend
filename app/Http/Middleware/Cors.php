<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    protected $unwantedHeaderList = [
			'Server',
			'X-Powered-By'
    ];

    public function handle($request, Closure $next)
    {
			$response = $next($request);
			$response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade', ' strict-origin-when-cross-origin');
			$response->headers->set('Access-Control-Allow-Origin', '*');
			$response->headers->set('Access-Control-Allow-Credentials', 'true');
			$response->headers->set('Access-Control-Allow-Headers', 'Origin, Accept, Content-Type, Authorization');
			$response->headers->set('Access-Control-Allow-Methods', 'PUT, POST, GET, DELETE, OPTIONS');
			$response->headers->set('Access-Control-Expose-Headers:','*');
			$response->headers->set('X-Content-Type-Options', 'nosniff');
			$response->headers->set('X-XSS-Protection', '1; mode=block');
			$response->headers->set('X-Frame-Options', 'DENY');
			$response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
			return $response;
    }
}
