<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Link;
use App\Models\Theme;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\PricingPlan;
use App\Models\SocialLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    // Google login
    function google() 
    {
        $google = SocialLogin::first();

        config(['services.google.client_id' => $google->client_id]);
        config(['services.google.client_secret' => $google->client_secret]);
        config(['services.google.redirect' => $google->redirect_url]);

        return Socialite::driver('google')->redirect();
    }

    function google_callback() 
    {
        try {
            $google = SocialLogin::first();

            config(['services.google.client_id' => $google->client_id]);
            config(['services.google.client_secret' => $google->client_secret]);
            config(['services.google.redirect' => $google->redirect_url]);

            $theme = Theme::get()->first();
            $plan = PricingPlan::where('name', 'BASIC')->first();
            $user = Socialite::driver('google')->user();
            $registered = User::where('google_id', $user->id)->first();

            if ($registered) {
                Auth::login($registered, true);
            } else {
                $app = AppSetting::get()->first();

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'image' => $user->avatar,
                    'password' => Hash::make('googleauth'),
                ])->assignRole('BASIC');

                $newUser->google_id = $user->id;
                $newUser->email_verified_at = now();
                $newUser->pricing_plan_id = $plan->id;
                $newUser->save();

                $link = new Link();
                $link->user_id = $newUser->id;
                $link->link_name = $user->name;
                $link->url_name = strtolower(str_replace(" ","", $user->name));;
                $link->theme_id = $theme->id;
                $link->branding = $app->logo;
                $link->save();

                event(new Registered($newUser));
                Auth::login($newUser, true);
            }

            return redirect(RouteServiceProvider::DASHBOARD);

        } catch (\Throwable $th) {
            // throw $th
            return redirect()->to('/login');
        }
    }
}
