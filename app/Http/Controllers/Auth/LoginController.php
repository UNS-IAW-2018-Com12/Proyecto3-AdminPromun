<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class LoginController extends Controller {
  use AuthenticatesUsers;

  protected function username() {
    return 'user';
  }

  public function __construct() {
    $this->middleware('guest')->except('logout');
  }

  public function showLoginForm() {
    return view('index');
  }

  public function login(Request $request) {


    $this->validate($request, ["username" => 'required|max:255',"password" => 'required|max:255']);

    $authUser = User::where($this->username(), '=', $request->username)->get();

    if(isset($authUser)) {
        $password = $request->password;
        if(Auth::attempt([$this->username() => $request->username, 'password' => $password])) {
          return redirect('/admin');
        }
        else {
          return redirect('/');
        }
    }
  }

  public function logout() {
    Auth::logout();
    return redirect('/');
  }
}
