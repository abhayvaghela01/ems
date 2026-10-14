<?php

namespace App\Http\Controllers\authentications;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }

  // store data
  public function store(Request $request)
  {

    $formField = $request->validate([
      'name' => ['required', 'min:2'],
      'email' => ['required', 'email', Rule::unique('users', 'email')],
      'password' => ['required', 'confirmed', 'min:6'],

    ]);

    // hash pass
    $formField['password'] = bcrypt($formField['password']);

    $user =  User::create($formField);

    // set default role member
    $user->assignRole('member');
    Auth::login($user);

    if ($user) {
      return redirect('/')->with('message', 'Registration successful!');
    } else {
      return back()->with('error', 'Registration failed. Please try again.');
    }
  }
}
