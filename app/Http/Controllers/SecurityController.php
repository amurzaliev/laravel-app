<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class SecurityController extends Controller
{
    public function showLogin()
    {
        return view('security.login');
    }

    public function doLogin(LoginUser $request)
    {
        $validated = $request->validated();

        $userdata = [
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ];

        if (!Auth::attempt($userdata)) {
            $errors = new MessageBag();
            $errors->add('login_failed', 'Login failed!');

            return redirect()->route('security_show_login')
                ->withErrors($errors)
                ->withInput();
        }

        // TODO: Refactor to through event and handle it in a separate service - CartService
        $user = Auth::user();
        $productIds = $request->session()->get(CartController::SESSION_CART, []);

        if (empty($productIds)) {
            $request->session()->put(CartController::SESSION_CART, $user->sessionCartData());
        }

        return redirect()->route('product_index');
    }

    public function doLogout()
    {
        Auth::logout();

        return redirect()->route('product_index');
    }
}
