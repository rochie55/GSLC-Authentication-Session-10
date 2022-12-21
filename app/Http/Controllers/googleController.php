<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
// use App\Http\Controllers\Auth;


class googleController extends Controller
{
    public function redirectGoogle(){
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callbackGoogle(){

        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'remember_token' => $googleUser->token,
            'password'=> bcrypt('12345678'),
        ]);

        Auth::login($user);

        return redirect('/login');

    }
}
