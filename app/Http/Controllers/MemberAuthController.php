<?php

namespace App\Http\Controllers;

use App\Models\Camel;
use App\Models\Member;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:member')->except('logout', 'dashboard', 'storeVote');
        $this->middleware('auth:member')->only(['logout', 'dashboard', 'storeVote']);
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('member.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('member')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('member.dashboard'));
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('member.login');
    }

    /**
     * Show the member dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $member = Auth::guard('member')->user();

        // Get recent camels only, without final votes, and include owner + votes relations
        $allCamels = Camel::with(['votes', 'owner'])
            ->whereNull('final_vote')
            ->orderByDesc('created_at')
            ->get();

        // Filter to get only camels the member hasn't voted on yet
        $camels = $allCamels->filter(function($camel) use ($member) {
            $hasVoted = Vote::where('camel_id', $camel->id)
                ->where('member_id', $member->id)
                ->exists();

            // Only keep camels that haven't been voted on
            return !$hasVoted;
        });

        return view('member.dashboard', compact('member', 'camels'));
    }

    /**
     * Store a vote from a member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeVote(Request $request)
    {
        $this->validate($request, [
            'camel_id' => 'required|exists:camels,id',
            'vote' => 'required|in:omaniat,mohagnat',
        ]);

        $member = Auth::guard('member')->user();

        // Check if member has already voted for this camel
        $existingVote = Vote::where('camel_id', $request->camel_id)
            ->where('member_id', $member->id)
            ->first();

        if ($existingVote) {
            return redirect()->back()->with('error', 'You have already voted for this camel.');
        }

        // Create new vote
        $vote = Vote::create([
            'camel_id' => $request->camel_id,
            'member_id' => $member->id,
            'vote' => $request->vote,
        ]);

        // After saving a vote: if camel doesn't have a final vote yet, check if all active members have voted.
        $camel = Camel::with('votes')->find($request->camel_id);
        if ($camel && is_null($camel->final_vote)) {
            $activeMembersCount = Member::where('is_active', 1)->count();

            // Count distinct member votes for this camel
            $distinctVotesCount = $camel->votes()->distinct('member_id')->count('member_id');

            if ($activeMembersCount > 0 && $distinctVotesCount >= $activeMembersCount) {
                // Compute final result following the same rule used in admin panel (superVote normal flow)
                $checkOmaniat = $camel->votes()->where('vote', 'omaniat')->count();
                $checkMohagnat = $camel->votes()->where('vote', 'mohagnat')->count();

                // Manager weighted votes: add manager votes once more to give them double weight
                $managerOmaniat = $camel->votes()
                    ->where('vote', 'omaniat')
                    ->whereHas('member', function ($q) { $q->where('role', 'manager'); })
                    ->count();

                $managerMohagnat = $camel->votes()
                    ->where('vote', 'mohagnat')
                    ->whereHas('member', function ($q) { $q->where('role', 'manager'); })
                    ->count();

                $totalOmaniat = $checkOmaniat + $managerOmaniat;
                $totalMohagnat = $checkMohagnat + $managerMohagnat;

                if ($totalOmaniat > $totalMohagnat) {
                    $camel->final_vote = 1; // omaniat
                } elseif ($totalMohagnat > $totalOmaniat) {
                    $camel->final_vote = 2; // mohagnat
                } else {
                    $camel->final_vote = 0; // tie
                }
                $camel->vote_source = 'normal';
                $camel->save();
            }
        }

        return redirect()->back()->with('success', 'Your vote has been recorded successfully.');
    }
}
