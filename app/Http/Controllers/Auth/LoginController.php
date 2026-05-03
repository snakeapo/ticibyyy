<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/';

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
        return view('customer::auth.login');
    }

    public function showAdminLoginForm()
    {
        return view('customer::auth.admin-login');
    }

    public function login(Request $request)
    {
        return $this->attemptCustomLogin($request);
    }

    public function adminLogin(Request $request)
    {
        return $this->attemptCustomLogin($request, true);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($request->routeIs('admin.login.submit') && $user->role === 'admin') {
            return redirect()->route('panel_home');
        }

        return redirect('/');
    }

    protected function attemptCustomLogin(Request $request, bool $onlyAdmin = false)
    {
        $this->validateLogin($request);

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->attempt($this->credentials($request, $onlyAdmin), $request->boolean('remember'))) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    }

    public function username(): string
    {
        return 'login';
    }

    protected function credentials(Request $request, bool $onlyAdmin = false): array
    {
        $login = (string) $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_phone';

        $credentials = [
            $field => $login,
            'password' => $request->input('password'),
        ];

        if ($onlyAdmin) {
            $credentials['role'] = 'admin';
        }

        return $credentials;
    }

    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'], true)) {
            abort(404);
        }

        return $this->socialiteDriver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'], true)) {
            abort(404);
        }

        $socialUser = $this->socialiteDriver($provider)->user();
        $providerIdColumn = $provider.'_id';

        $user = User::where($providerIdColumn, $socialUser->getId())
            ->when($socialUser->getEmail(), function ($query) use ($socialUser) {
                $query->orWhere('email', $socialUser->getEmail());
            })
            ->first();

        if (!$user) {
            $nameParts = preg_split('/\s+/', trim((string) $socialUser->getName())) ?: [];
            $name = $nameParts[0] ?? ($provider === 'google' ? 'Google' : 'Facebook');
            $surname = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : 'User';

            $user = User::create([
                'name' => $name,
                'surname' => $surname,
                'avatar' => 'avatar.png',
                'identy' => (string) (date('His') * random_int(999, 99999)),
                'balance' => 0,
                'role' => 'user',
                'sex' => 'male',
                'email' => $socialUser->getEmail() ?: sprintf('%s_%s@social.local', $provider, Str::uuid()),
                'password' => Hash::make(Str::random(40)),
                $providerIdColumn => $socialUser->getId(),
            ]);
        } else {
            $user->update([
                $providerIdColumn => $socialUser->getId(),
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended('/');
    }

    protected function socialiteDriver(string $provider)
    {
        $settings = Settings::findOrFail(1);

        $config = $provider === 'google'
            ? [
                'client_id' => $settings->google_client_id,
                'client_secret' => $settings->google_client_secret,
                'redirect' => $settings->google_redirect_uri ?: route('social.callback', ['provider' => 'google']),
            ]
            : [
                'client_id' => $settings->facebook_client_id,
                'client_secret' => $settings->facebook_client_secret,
                'redirect' => $settings->facebook_redirect_uri ?: route('social.callback', ['provider' => 'facebook']),
            ];

        abort_if(empty($config['client_id']) || empty($config['client_secret']) || empty($config['redirect']), 500, __('Sosyal giriş ayarları eksik.'));

        return Socialite::buildProvider(
            $provider === 'google'
                ? \Laravel\Socialite\Two\GoogleProvider::class
                : \Laravel\Socialite\Two\FacebookProvider::class,
            $config
        )->stateless();
    }
}
