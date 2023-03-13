<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Test;


class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }

    public function current(Request $request){
        $user_id = $request->user()->id;
        $tests = Test::where('user_id',$user_id)->get();
        $counted = $tests->countBy(function (Test $test) {
            return $test->type;
        });

        $has_completed_tutorial = $counted->has('0');
        $has_completed_initial_test = $counted->has('1');
        $has_completed_final_test = $counted->has('2');

        $response = $request->user();
        $response->has_completed_tutorial = $has_completed_tutorial;
        $response->has_completed_initial_test = $has_completed_initial_test;
        $response->has_completed_final_test = $has_completed_final_test;

        return $response;
    }
}
