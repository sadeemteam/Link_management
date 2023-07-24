<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\PricingPlan;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    
        // $theme = Theme::get()->first();
        // $plan = PricingPlan::where('name', 'BASIC')->first();

        User::create([
            'name' => 'UI-Lib',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin'),
        ])->assignRole('SUPER-ADMIN');

        // $user = User::create([
        //     'name' => 'User',
        //     'email' => 'user@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'pricing_plan_id' => $plan->id,
        // ])->assignRole('BASIC');

        // $link = new Link();
        // $link->user_id = $user->id;
        // $link->link_name = 'User';
        // $link->url_name = 'user';
        // $link->theme_id = $theme->id;
        // $link->save();
    }
}
