<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



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
        $this->middleware('auth')->only('logout');
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $loginToken = session('login_token');

            if ($loginToken) {
                // 👉 Soft revoke
                // DB::table('tokens')
                //     ->where('user_id', $user->id)
                //     ->where('value', $loginToken)
                //     ->update([
                //         'is_revoked' => 1,
                //         'updated_at' => now(),
                //     ]);

                // 👉 Kalau mau hard delete, ganti aja ke:
                DB::table('tokens')
                    ->where('user_id', $user->id)
                    ->where('value', $loginToken)
                    ->delete();
            }

            // Hapus dari session
            session()->forget('login_token');
        }

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
