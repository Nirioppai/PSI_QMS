<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
  {
    if (Auth::guard('web')->check()) {
      return redirect()->intended(route('superadminhome'));
    }

    if (Auth::guard('queue_admin')->check()) {
      return redirect()->intended(route('queueadminhome'));
    }

    if (Auth::guard('station_admin')->check()) {
      return redirect()->intended(route('stationadminhome'));
    }

    if (Auth::guard('window_admin')->check()) {
      return redirect()->intended(route('windowadminhome'));
    }

    if (Auth::guard('flashboard')->check()) {
      return redirect()->intended(route('flashboardhome'));
    }

    if (Auth::guard('kiosk')->check()) {
      return redirect()->intended(route('kioskhome'));
    }

    return view('auth.login');
  }

  public function login(Request $request)
  {
    $this->validate($request, [
      'username' => 'required',
      'password' => 'required|min:8'
    ]);

    if(Auth::guard('web')->attempt(['username'=>$request->username, 'password'=>$request->password], $request->remember))
    {
      return redirect()->intended(route('superadminhome'));
    }

    elseif(Auth::guard('queue_admin')->attempt(['username'=>$request->username, 'password'=>$request->password], $request->remember))
    {
      return redirect()->intended(route('queueadminhome'));
    }

    elseif(Auth::guard('station_admin')->attempt(['username'=>$request->username, 'password'=>$request->password], $request->remember))
    {
      return redirect()->intended(route('stationadminhome'));
    }

    elseif(Auth::guard('window_admin')->attempt(['username'=>$request->username, 'password'=>$request->password], $request->remember))
    {
      return redirect()->intended(route('windowadminhome'));
    }

    elseif(Auth::guard('flashboard')->attempt(['username'=>$request->username, 'password'=>$request->password], $request->remember))
    {
      return redirect()->intended(route('flashboardhome'));
    }
    elseif(Auth::guard('kiosk')->attempt(['username'=>$request->username, 'password'=>$request->password], $request->remember))
    {
      return redirect()->intended(route('kioskhome'));
    }


    return redirect()->back()->withInput($request->only('username', 'remember'));
  }

  public function logout()
  {
      Auth::guard('web')->logout();
      Auth::guard('queue_admin')->logout();
      Auth::guard('station_admin')->logout();
      Auth::guard('window_admin')->logout();
      Auth::guard('flashboard')->logout();
      Auth::guard('kiosk')->logout();
      return redirect('/');
  }
}
