<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function singIn(LoginRequest $request)
    {
        $credentials = [
            "name" => $request->get('login'),
            "password" => $request->get('password'),
        ];

        if (Auth::attempt($credentials, $request->get("remember_me"))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            "Login or password is incorrect"
        ]);
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function singUp(RegisterRequest $request)
    {
        if (User::query()->firstWhere("name", '=', $request->get("login"))) {
            return back()->withErrors([
                "This user already exist"
            ]);
        }

        $user = new User;

        $user->name = $request->input("login");
        $user->password = bcrypt($request->input("password"));
        $user->email = bcrypt($request->input("email"));

        $user->save();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('welcome');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->regenerate();

        $request->session()->regenerateToken();

        return redirect()->route('login.init');
    }
}
