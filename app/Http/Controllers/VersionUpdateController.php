<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VersionUpdateController extends Controller
{
    public function index()
    {
        return view('setup.admin-login');
    }

    public function admin_login(Request $request)
    {        
        $user = User::where('email', $request->email)->first();
        if (!$user) return back()->with('error', 'Admin email or password not found matched.');

        $isMatch = Hash::check($request->password, $user->password);
        if (!$isMatch) return back()->with('error', 'Admin email or password not found matched.');

        if ($user->hasRole('SUPER-ADMIN')) {
            Auth::login($user, true);
            return redirect()->to('/version/update/step-2');
        } else {
            return back()->with('error', 'Your are not admin');
        }
    }

    public function update()
    {
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');

        if ($SA) {
            return view('setup.update');
        } else {
            return back()->with('error', 'Your are not admin');
        }
    }

    public function store()
    {
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');
        
        if ($SA) {
            Artisan::call('migrate --force');
            return redirect()->to('/dashboard');
        } else {
            return back()->with('error', 'Your are not admin');
        }
    }
}
