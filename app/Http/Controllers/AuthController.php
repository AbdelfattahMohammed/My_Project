<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle login and check user role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        // Validate the request

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $role = $user->role;

            // Check user role and return a message
            switch ($role) {
                case 'admin':
                    return to_route('admin.index');
                case 'employer':
                    return to_route('employer.index');
                case 'candidate':
                    return to_route('candidate.index');
                default:
                    Auth::logout();
                    return redirect()->back()->with('error', 'Invalid role!');
            }
        }

        // Authentication failed
        return redirect()->back()->with('error', 'Your email or password is wrong.');
    }

    public function index(){
        $role=Auth::user()->role;
        switch ($role) {
            case 'admin':
                return to_route('admin.index');
            case 'employer':
                return to_route('employer.index');
            case 'candidate':
                return to_route('candidate.index');
            default:
                Auth::logout();
                return redirect()->back()->with('error', 'Invalid role!');
        }
    }
}
