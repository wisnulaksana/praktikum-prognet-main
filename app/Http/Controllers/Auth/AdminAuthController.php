<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AdminAuthController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('postLogout');
    }

    public function getLogin()
    {
        return view('auth.admin.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:5'
        ]);

        if (auth()->guard('admin')->attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            return redirect(Route('admin'));
        } else {
            $this->incrementLoginAttempts($request);

            return redirect()
                ->back()
                ->with('error','Incorrect user login details!');
        }
    }

    public function postLogout()
    {
        auth()->guard('admin')->logout();
        session()->flush();

        return redirect()->route('admin.login');
    }
}
