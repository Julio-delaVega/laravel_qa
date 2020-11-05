<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getToken(Request $req)
    {
      $req->request->add([
        'grant_type' => 'password',
        'client_id' => 2,
        'client_secret' => 'G9OOaY6ZDKhqt5BMLlyhRMHa7lsJiOyuDsQdqmrg',
        'username' => $req->username,
        'password' => $req->password
      ]);

      $request_token = Request::create(env('APP_URL').'/oauth/token', 'post');
      $response = Route::dispatch($request_token);

      return $response;
    }
}
