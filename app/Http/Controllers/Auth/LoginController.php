<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Parser\Cookies as CookiesParser;

class LoginController extends Controller
{
    /**
     * @var string
     */
    protected $cookieKey;

    /**
     * Create a new controller instance.
     *
     * @param \Tymon\JWTAuth\Http\Parser\Cookies $cookies
     * @return void
     */
    public function __construct(CookiesParser $cookies)
    {
        $this->cookieKey = $cookies->getKey();
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'invalid_credentials',
                    'msg' => 'Invalid Credentials'
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'could_not_create_token',
                'msg' => 'Could not create token'
            ], 500);
        }
        setcookie('token',$token,time()+3600,'/');
//        Cookie::queue('token', $token, 10, null, null, true, false);
        $user = User::where("email",'=',$request->get('email'));
        $user->update([
            'remember_token'=>$token,
        ]);
        return response()->json([
            'status' => 'success',
            'token'=>$token,
        ], 200);
    }

    public function logout()
    {
        try {
            JWTAuth::setToken($_COOKIE['token'])->invalidate()->unsetToken();
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'failed_logout',
                'msg' => 'Failed to logout, please try again.'
            ], 500);
        }
        //$user = User::where("remember_token",'=',Cookie::get($this->cookieKey));
        $user = User::where("remember_token",'=',$_COOKIE['token']);
        $user->update([
            'remember_token'=>'',
        ]);

        //Cookie::queue(Cookie::forget($this->cookieKey));
        setcookie('token','',time(),'/');
        return redirect('/');
    }
}
