<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found or invalid verification link.',
            ], 404);
        }
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired verification link.',
            ], 403);
        }
        if ($user->hasVerifiedEmail()) {
            return redirect(env('FRONTEND_URL') . '/auth/verify?already_verified=true&email=' . urlencode($user->email));
        }
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return redirect(env('FRONTEND_URL') . '/auth/verify?verify=true&email=' . urlencode($user->email));
    }
}
