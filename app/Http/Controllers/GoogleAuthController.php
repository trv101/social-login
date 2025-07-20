<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
{
    try {
        $google_user = Socialite::driver('google')->user();

        // Check if user exists by google_id or email
        $user = User::where('google_id', $google_user->getId())
                    ->orWhere('email', $google_user->getEmail())
                    ->first();

        if ($user) {
            // Update google_id if missing
            if (is_null($user->google_id)) {
                $user->google_id = $google_user->getId();
                $user->save();
            }

            Auth::login($user);
        } else {
            // Create new user
            $new_user = User::create([
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'google_id' => $google_user->getId()
            ]);
            Auth::login($new_user);
        }

        return redirect()->intended('dashboard');

    } catch (\Throwable $th) {
        dd('Something went wrong! ' . $th->getMessage());
    }
}
}
