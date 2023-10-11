<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\PasswordReset;
use App\User;
use Mail;
Use Str;

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

    public function forgotPassword() {
        return view('auth.login');
    }

    public function sendForgotPassword(Request $request) {
        $email = $request->email;
        $exist = User::where('email', $email)->first();

        if ($exist) {
            $token = Str::random(60);
            PasswordReset::insert([
                'email' => $email,
                'token' => $token
            ]);
            Mail::send('email.password-reset', ['token' => $token, 'name' => $exist->name], function($message) use ($email) {
                $message->to($email)
                ->subject('RESET PASSWORD')
                ->from('info@artcavegallery.com', 'ArtCave Gallery');
            });
            return redirect()->back()->with('success', 'An email has been sent to your email address');
        } else {
            return redirect()->back()->with('error', 'Account does not exist');
        }
    }

    public function resetPassword($token) {
        $exist = PasswordReset::where('token', $token)->first();
        if ($exist) {
            if (date('Y-m-d H:i:s', strtotime($exist->created_at . '+24 hours')) > date('Y-m-d H:i:s', strtotime(now()))) {
                return view('auth.reset-password', compact('token'));
            } else {
                return view('auth.reset-password')->with('error', 'The link has already expired');
            }
        } else {
            return view('auth.reset-password')->with('error', 'The link has already expired');
        }
        return $exist;
    }

    public function saveNewPassword($token) {
        $password = request()->password;
        $retype = request()->retype;
        $exist = PasswordReset::where('token', $token)->first();
        if ($exist) {
            if (date('Y-m-d H:i:s', strtotime($exist->created_at . '+24 hours')) > date('Y-m-d H:i:s', strtotime(now()))) {
                if ($password == $retype) {
                    User::where('email', $exist->email)
                    ->update([
                        'password' => bcrypt($password)
                    ]);
                    return view('auth.reset-password')->with('success', 'Your password was successfully updated');
                } else {
                    return redirect()->back()->with('error', 'The new password and confirmation password do not match');
                }
                return view('auth.reset-password', compact('token'));
            } else {
                return view('auth.reset-password')->with('error', 'The link has already expired');
            }
        } else {
            return view('auth.reset-password')->with('error', 'The link has already expired');
        }
        return $exist;
    }
}
