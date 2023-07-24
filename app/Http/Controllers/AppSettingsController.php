<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\SmtpSetting;
use App\Models\SocialLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class AppSettingsController extends Controller
{
    private $config;

    public function __construct(){
        $this->config = base_path('config/app.php');
    }

    public function configRewrite($key, $prevValue, $newValue) 
    {
        file_put_contents(
            $this->config, 
            str_replace("'$key' => '".$prevValue."'", "'$key' => '".$newValue."'", file_get_contents($this->config))
        );
    }


    // Getting app info
    public function index(Request $req){
        try {
            $app = AppSetting::first();
            $smtp = SmtpSetting::first();
            $google = SocialLogin::where('name', 'google')->first();

            return view('pages.admin.app-settings', compact('app', 'smtp', 'google'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }


    // Auth settings for admin
    public function auth_google(Request $request)
    {
        $request->validate([
            'google_client_id' => 'max:200',
            'google_client_secret' => 'max:100',
            'google_redirect' => 'max:100',
        ]);
        $google_login_allow = $request->google_login_allow ? true : false;

        try {
            SocialLogin::where('name', 'google')->update([
                'active' => $google_login_allow,
                'client_id' => $request->google_client_id,
                'client_secret' => $request->google_client_secret,
                'redirect_url' => $request->google_redirect,
            ]);

            return back()->with('success', 'Google auth successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Internal server error!. Try again later.');
        }
    }


    // Global settings for admin
    public function global_update(Request $request) 
    {
        $request->validate([
            'app_name' => 'required|max:50',
            'app_copyright' => 'required|max:100',
            'description' => 'required|max:200',
        ]);
        
        try {
            $app = AppSetting::first();

            if ($request->app_logo) {
                $rules = [
                    'app_logo' => 'image|mimes:jpg,png,jpeg|max:5120',
                ];
                $messages = [
                    'app_logo.mimes' => 'Allow only jpg,png,jpeg type image',
                    'app_logo.max' => 'Image size will be 5MB',
                ];
                $this->validate($request, $rules, $messages, );
                
                if(strpos($app->logo, "asses/icons") !== false){
                    File::delete($app->logo);
                }
    
                $location = public_path('/upload/');
                $image = Image::make($request->app_logo);
                $image->save($location.time().$request->app_logo->getClientOriginalName());
    
                $app->logo = 'upload/'.$image->filename.'.'.$image->extension;
            }

            $app->title = $request->app_name;
            $app->copyright = $request->app_copyright;
            $app->description = $request->description;
            $app->save();
            
            return back()->with('success', 'Global settings successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Internal server error!. Try again later.');
        }
    }


    // SMTP settings for admin
    public function smtp_update(Request $request) 
    {
        // dd($request->all());
        $request->validate([
            'smtp_host' => 'required|max:50',
            'smtp_port' => 'required|max:10',
            'smtp_username' => 'required|max:50',
            'smtp_password' => 'required|max:100',
            'smtp_encryption' => 'required|max:10',
            'mail_from_address' => 'required|max:100|email',
            'mail_from_name' => 'required|max:50',
        ]);

        try {
            $smtp = SmtpSetting::first();

            $smtp->host = $request->smtp_host;
            $smtp->port = $request->smtp_port;
            $smtp->username = $request->smtp_username;
            $smtp->password = $request->smtp_password;
            $smtp->sender_email = $request->mail_from_address;
            $smtp->sender_name = $request->mail_from_name;
            $smtp->encryption = $request->smtp_encryption;
            $smtp->save();

            return back()->with('success', 'SMTP successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Internal server error!. Try again later.');
        }
    }
}
