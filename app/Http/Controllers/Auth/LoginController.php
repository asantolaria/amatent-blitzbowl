<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
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

    protected function redirectTo()
    {
        return $this->redirectTo;
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');

        // Check if the user exists and is enabled
        $user = \App\Models\User::where($this->username(), $credentials[$this->username()])
            ->where('enabled', true)
            ->first();

        if ($user) {
            return Auth::attempt($credentials, $request->filled('remember'));
        }

        return false;
    }

    /**
     * Send the response after the user failed to authenticate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();

        if ($user && !$user->enabled) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors(['email' => 'Tu cuenta está deshabilitada. Contacta con el administrador.']);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}
