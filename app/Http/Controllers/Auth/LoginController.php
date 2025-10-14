    <?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class LoginController extends Controller
    {
        use AuthenticatesUsers;

        protected $redirectTo = '/home';

        public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->middleware('auth')->only('logout');
        }

        /**
         * Handle after successful login
         */
        protected function authenticated(Request $request, $user)
    {
        $token = $user->createToken('web_login')->plainTextToken;

        if ($request->expectsJson()) {
            return response()->json([
                'message'      => 'Login success',
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'user'         => $user,
            ]);
        }

        // Simpan token di session agar bisa dihapus nanti
        session(['sanctum_token' => $token]);

        return redirect()->intended($this->redirectPath());
    }


        /**
         * Logout & revoke token
         */
        public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Ambil token dari header atau session (kalau login via web)
            $token = $request->bearerToken() ?? session('sanctum_token');

            if ($token) {
                // Pisahkan format "1|g7lk9WQZ..." jadi id + plain token
                $parts = explode('|', $token, 2);
                $plain = $parts[1] ?? null;

                if ($plain) {
                    // Hapus token yang sesuai
                    $user->tokens()
                        ->where('token', hash('sha256', $plain))
                        ->delete();
                } else {
                    // Kalau format token tidak ada "|", hapus semua token user
                    $user->tokens()->delete();
                }
            } else {
                // Tidak ada token di session/header → hapus semua saja
                $user->tokens()->delete();
            }
        }

        // Bersihkan session
        session()->forget('sanctum_token');
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout success']);
        }

        return redirect('/');
    }

    }
