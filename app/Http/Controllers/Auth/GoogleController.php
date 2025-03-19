<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    // Redirect to Google for authentication
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback from Google
    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();
        
        // Find or create the user based on Google information
        $findUser = User::where('google_id', $user->id)->first();
        
        if ($findUser) {
            // Log the user in
            Auth::login($findUser);
            return redirect()->intended('home');
        } else {
            $user = User::updateOrCreate(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'password' => encrypt('12345678'),
                ]
            );
            Auth::login($user);
        }

        return redirect()->intended('home');
    }
}
