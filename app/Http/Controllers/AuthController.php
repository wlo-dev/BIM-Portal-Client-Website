<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function  showRegister()
    {
        return view('auth.register');
    }
    public function register(Request $request): RedirectResponse
    {
         $data = $request->validate([
            'name'=> ['required', 'string', 'max:100]',
            'email'=> ['required', 'email', 'max:225', 'unique:users,email'],
            'password'=> ['required', 'confirmed', Password::min(8)],
        ]);
        $user = User::create($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('account')->with('status', ' Welcome to BIM Portal Site');
    }
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' =>['required']
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
            ->withErrors(['email => 'The provided credentials do not match our records.'])
            ->onlyInput('email');
        }
        $request->session()->regenerate();

        return redirect()->intended(route('account'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::Logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
