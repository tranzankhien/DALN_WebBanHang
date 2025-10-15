<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        //return Socialite::driver($provider)->redirect();
        $driver = Socialite::driver($provider);
        if ($provider === 'google') {
            // Build redirect URL and append prompt=select_account without relying on provider-specific methods
            $response = $driver->redirect();
            $url = $response->getTargetUrl();
            $separator = (strpos($url, '?') === false) ? '?' : '&';
            $url .= $separator.'prompt=select_account';
            return redirect()->away($url);
        }
        return $driver->redirect();
    }



    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // 1) Find by provider link
            $user = User::where([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ])->first();

            if (!$user) {
                // 2) Find by email and link provider
                $user = User::where('email', $socialUser->getEmail())->first();
                if ($user) {
                    $user->provider = $provider;
                    $user->provider_id = $socialUser->getId();
                    $user->avatar = $socialUser->getAvatar();
                    if (!$user->email_verified_at) {
                        $user->email_verified_at = now();
                    }
                    $user->save();
                } else {
                    // 3) Create new account (default role = customer)
                    $user = User::create([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        'password' => bcrypt(uniqid()), // Random password
                        'role' => 'customer',
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'avatar' => $socialUser->getAvatar(),
                        'email_verified_at' => now(),
                    ]);
                }
            }

            Auth::login($user);
            
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('home');
            
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Đăng nhập Google thất bại.');
        }
    }
}
