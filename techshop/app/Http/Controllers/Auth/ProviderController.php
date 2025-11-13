<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\InvalidStateException;

class ProviderController extends Controller
{
   public function redirect(Request $request, string $provider)
    {
        if (! in_array($provider, ['google', 'facebook'], true)) {
            abort(404);
        }

        // Use the current request host as callback to avoid domain mismatches (e.g. 127.0.0.1 vs localhost)
        $callbackUrl = route('social.callback', ['provider' => $provider], true);
        $driver = Socialite::driver($provider)->redirectUrl($callbackUrl);

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



    public function callback(Request $request, string $provider)
    {
        try {
            if (! in_array($provider, ['google', 'facebook'], true)) {
                abort(404);
            }

            $callbackUrl = route('social.callback', ['provider' => $provider], true);
            $socialUser = Socialite::driver($provider)
                ->redirectUrl($callbackUrl)
                ->user();

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
            $request->session()->regenerate();
            
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('home');
            
        } catch (InvalidStateException $e) {
            // Thường xảy ra khi domain truy cập khác với callback (vd: 127.0.0.1 vs localhost)
            return redirect('/login')->with('error', 'Đăng nhập thất bại do khác domain. Vui lòng dùng cùng một địa chỉ (ví dụ cùng localhost hoặc cùng 127.0.0.1).');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Đăng nhập mạng xã hội thất bại. Vui lòng thử lại.');
        }
    }
}
