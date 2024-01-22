<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // dd(env('ENV'));
        if(env('ENV') == 'DEV')
            return $next($request);
        // execute the request and get the response
        $response = $next($request);

        // get the response data
        $responseData = $response->getContent();

        // add a custom salt to the data before encryption
        $dataWithSalt = env('ENCRYPT_SALT') . $responseData;

        // encrypt the data with the salt
        $encryptedData = Crypt::encrypt($dataWithSalt, true);

        // set the encrypted data as the new content of the response
        $response->setContent($encryptedData);

        // return the updated response
        return $response;
    }

}
