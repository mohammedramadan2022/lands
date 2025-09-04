<?php

namespace App\Http\Middleware\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\Api_Trait;
use Closure;
use Exception;
use JWTAuth;
use Illuminate\Http\Request;

class ApiLogin extends Controller
{
    use Api_Trait;

    public function handle(Request $request, Closure $next)
    {
        try {

            $patient = auth('patient')->user();

            if (!$patient) {
           return     $this->returnError([helperTrans('api.Unauthorized')],401);
            }
        } catch (Exception $e) {
            return     $this->returnError([helperTrans('api.Token is invalid or expired')],401);

        }

        return $next($request);
    }
}
