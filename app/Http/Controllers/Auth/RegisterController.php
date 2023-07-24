<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Link;
use App\Models\PricingPlan;
use App\Models\SmtpSetting;
use App\Models\SocialLogin;
use App\Models\Theme;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\CheckLinkName;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                return redirect()->back();
            }else{
                $smtp = SmtpSetting::first();

                config(['mail.mailers.smtp.host' => $smtp->host]);
                config(['mail.mailers.smtp.port' => $smtp->port]);
                config(['mail.mailers.smtp.username' => $smtp->username]);
                config(['mail.mailers.smtp.password' => $smtp->password]);
                config(['mail.mailers.smtp.encryption' => $smtp->encryption]);
                config(['mail.from.address' => $smtp->sender_email]);
                config(['mail.from.name' => $smtp->sender_name]);

                $google = SocialLogin::where('name', 'google')->first();
                view()->share('google', $google);
                return $next($request);
            }
        });
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'url_name' => ['required', 'string', 'max:50', 'unique:links', new CheckLinkName],
        ];

        $messages = [
            'name.max' => 'Name length will be 1 to 50 character.',
            'email.unique' => 'Email is used by another account',
            'email.email' => 'Email must be a valid email',
            'password.confirmed' => "Confirm password didn't match.",
            'password.min' => "Minimum 6 Character needed",
            'password.required' => "Confirm password didn't match.",
            'url_name.max' => 'Username length will be 1 to 50 character.',
            'url_name.unique' => 'Link name is not available, please try another.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $theme = Theme::get()->first();
        $app = AppSetting::get()->first();
        $plan = PricingPlan::where('name', 'BASIC')->first();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ])->assignRole('BASIC');
        $user->pricing_plan_id = $plan->id;
        $user->save();

        $link = new Link();
        $link->user_id = $user->id;
        $link->link_name = $data['name'];
        $link->url_name = $data['url_name'];
        $link->theme_id = $theme->id;
        $link->branding = $app->logo;
        $link->save();

        return $user;
    }
}
