<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Subscription;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $freeSubscription = Subscription::where('days', 0)->first();
            if ($freeSubscription && $user->subscription_id && $user->subscription_id != $freeSubscription->id) {
                $currentSubscription = Subscription::find($user->subscription_id);
                if ($currentSubscription && Carbon::parse($user->expire_at)->isPast()) {
                    $user->update([
                        'subscription_id' => $freeSubscription->id,
                        'expire_at' => null,
                    ]);
                }
            }
        }

        return $next($request);
    }
}
