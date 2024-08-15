<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\AuthLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login (AuthLoginRequest $request)
  {
    $validateFields = [
      'email' => 'required|email',
      'password' => 'required'
    ];

    $request->validate($validateFields);
    
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');
    
    $authenticated = Auth::attempt($credentials, $remember);

    if (!$authenticated) {
        return redirect()->route('auth-login-basic')->with(['error' => 'Email or password invalid']);
    }

    return redirect()->route('dashboard-analytics');
  }

  public function logout ()
  {
    Auth::logout();
    return redirect()->route('auth-login');
  }
}
