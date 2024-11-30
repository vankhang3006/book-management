<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // For bcrypt


class FacebookAuthController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $findUser = User::where('email', $facebookUser->email)->first();
            if ($findUser) {
                Auth::login($findUser);
                $findUser->update([
                    'facebook_id' => $facebookUser->id, // Cập nhật facebook_id
                ]);
                return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email,
                    'facebook_id' => $facebookUser->id,
                    'password' => bcrypt('12345678'),
                ]);
                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Something went wrong');
        }

    }
    
}
