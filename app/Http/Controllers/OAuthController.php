<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $User = Socialite::driver($provider)->user();
        $user = User::updateOrCreate([
            $provider . '_id' => $User->id,
        ], [
            'name' => $User->name,
            'password' => 'secretgithub',
            'email' => $User->email,
            $provider . '_token' => $User->token,
            $provider . '_refresh_token' => $User->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
