<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle redirection after successful login.
     */
    protected function authenticated(Request $request, $user)
    {
        $user->session_id = session()->getId();
        $user->save();
        $role = $user->getType->key; // A = Admin, S = Student

        if ($role === 'A') {
            return redirect()->route('home');
        }

        if ($role === 'S') {
            return redirect()->route('home-student');
        }

        return redirect('/home');
    }
}
