<?php

namespace App\Http\Controllers;
use App\Models\QRCode;
use App\Models\Link;
use App\Models\Project;
use App\Models\ShetabitVisit;

class DashboardController extends Controller
{
    public function index() 
    {
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');
        session(['settings'=> true, 'blocks'=> false]);   
        
        if ($SA) {
            $links = Link::all();
            $qrcodes = QRCode::all();
            $projects = Project::all();
            $analytics = ShetabitVisit::all();

            return view('pages.dashboard', compact('qrcodes', 'links', 'analytics', 'projects'));
        } else {
            $links = Link::where('user_id', $user->id)->get();
            $qrcodes = QRCode::all()->where('user_id', $user->id);
            $projects = Project::where('user_id', $user->id)->get();
            $analytics = ShetabitVisit::where('visitor_id', $user->id)->get();

            return view('pages.dashboard', compact('qrcodes', 'links', 'analytics', 'projects'));
        }
    }
}
