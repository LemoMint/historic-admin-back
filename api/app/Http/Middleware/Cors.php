<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //TODO fix origin
        $headers = [
            ["Access-Control-Allow-Origin" => "*"],
            ["Access-Control-Allow-Credentials" => true],
            ["Access-Control-Allow-Methods" => "GET, POST, PATCH, DELETE, OPTIONS"]
        ];

        foreach ($headers as $header => $value) {
            $request->headers->set($header, $value);
        }

        return $next($request);
    }
}
