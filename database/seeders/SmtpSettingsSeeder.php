<?php

namespace Database\Seeders;

use App\Models\SmtpSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmtpSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SmtpSetting::create([
            'host' => '',
            'port' => '',
            'username' => '',
            'password' => '',
            'sender_email' => '',
            'sender_name' => 'LinkDrop',
            'encryption' => 'tls',
        ]);
    }
}
