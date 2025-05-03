<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  // Authenticate user
  public function authenticate(Request $request)
  {

    $formField = $request->validate([
      'email' => ['required', 'email'],
      'password' => 'required',
    ]);

    if (auth()->attempt($formField)) {
      $request->session()->regenerate();

      return redirect('/')->with('message', 'You are logged in successfully!');
    }

    return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
  }

  // Logout 
  public function logout(Request $request)
  {

    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('message', 'You have been logged out!');
  }
}
