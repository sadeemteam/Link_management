<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;

class PlanController extends Controller
{
    public function GetPlan() 
    {
        $user = auth()->user();
        $SA = $user->hasRole('SUPER-ADMIN');
        
        if ($SA) {
            $plans = PricingPlan::all();
            return view('pages.admin.plan.show', compact('plans'));
        } else {
            $plans = PricingPlan::where('status', 'active')->get();
            return view('pages.plan-update', compact('plans'));
        }
    }
    // -----------------------------------------


    public function UserPlan() 
    {
        try {
            $user = auth()->user();
            $plan = PricingPlan::where('id', $user->pricing_plan_id)->first();
            $subscription = Subscription::where('id', $user->subscription_id)->first();
            
            return view('pages.plan', compact('plan', 'subscription'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
    // -----------------------------------------

    
    // Create plan page
    public function CreatePlan(Request $req) 
    {
        return view('pages.admin.plan.create');
    }
    // -----------------------------------------


    // Created plan store
    public function StorePlan(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'description' => 'required|max:60',
            'monthly_price' => 'required',
            'yearly_price' => 'required',
            'currency' => 'required',
            'status' => 'required',
            'biolinks' => 'required',
            'biolink_blocks' => 'required',
            'shortlinks' => 'required',
            'projects' => 'required',
            'qrcodes' => 'required',
            'themes' => 'required',
            'custom_theme' => 'required',
            'support' => 'required',
        ]);

        try {
            PricingPlan::create($req->all());

            return redirect()->route('plans')->with('success', 'A new pricing plan have created');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('plans')->with('error', $th->getMessage());
        }
    }
    // -----------------------------------------


    // Plan update page
    public function GetPlanUpdate(Request $req, $id) 
    {
        try {
            $plan = PricingPlan::where('id', $id)->first();

            return view('pages.admin.plan.update', compact('plan'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('plans')->with('error', $th->getMessage());
        }
    }


    // Update pricing plan details
    public function PlanUpdate(Request $req, $id) 
    {
        $req->validate([
            'name' => 'required',
            'description' => 'required|max:60',
            'monthly_price' => 'required',
            'yearly_price' => 'required',
            'currency' => 'required',
            'status' => 'required',
            'biolinks' => 'required',
            'biolink_blocks' => 'required',
            'shortlinks' => 'required',
            'projects' => 'required',
            'qrcodes' => 'required',
            'themes' => 'required',
            'custom_theme' => 'required',
            'support' => 'required',
        ]);

        try {
            PricingPlan::where('id', $id)->update([
                'name' => $req->name,
                'description' => $req->description,
                'monthly_price' => $req->monthly_price,
                'yearly_price' => $req->yearly_price,
                'currency' => $req->currency,
                'status' => $req->status,
                'biolinks' => $req->biolinks,
                'biolink_blocks' => $req->biolink_blocks,
                'shortlinks' => $req->shortlinks,
                'projects' => $req->projects,
                'qrcodes' => $req->qrcodes,
                'themes' => $req->themes,
                'custom_theme' => $req->custom_theme,
                'support' => $req->support,
            ]);

            return redirect()->route('plans')->with('success', 'Pricing plan successfully updated');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('plans')->with('error', $th->getMessage());
        }
    }
    // -----------------------------------------


    // -----------------------------------------
    // When user select pro plan to basic plan
    public function BasicPlan($id)
    {
        $user = User::where('id', auth()->user()->id)->first();

        $user->pricing_plan_id = $id;
        $user->next_payment = null;
        $user->subscription_id = null;
        $user->recurring = null;
        $user->save();
                
        return redirect()->route('plan')->with('success', 'Your plan is successfully down on the basic plan.');
    }
}
