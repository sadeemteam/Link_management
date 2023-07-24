<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use App\Models\PricingPlan;
use App\Models\Subscription;


class SubscriptionController extends Controller
{
    // -----------------------------------------
    // View payment history only for super admin
    public function SubscriptionHistory()
    {
        try {
            $subscriptions = Subscription::paginate(10);
            return view('pages.admin.subscription_history', compact('subscriptions'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('plan')->with('error', $th->getMessage());
        }
    }
    // -----------------------------------------


    // -----------------------------------------
    // Getting the billing information
    public function Billing(Request $req, $id)
    {
        try {
            $type = $req->query()['type'];
            if ($type && $type == 'monthly' || $type == 'yearly') {
                $user = auth()->user();
                $plan = PricingPlan::where('id', $id)->first();
                $methods = PaymentGateway::all();
                $stripe = PaymentGateway::where('name', 'stripe')->first();
                $razorpay = PaymentGateway::where('name', 'razorpay')->first();
                $paypal = PaymentGateway::where('name', 'paypal')->first();
                $mollie = PaymentGateway::where('name', 'mollie')->first();
                $paystack = PaymentGateway::where('name', 'paystack')->first();
                // compact('stripe', 'razorpay', 'paypal', 'mollie', 'paystack')

                return view('pages.checkout', compact('plan', 'type', 'methods'));
            }else{
                return redirect()->route('plan')->with('error', 'Query param is not found or invalid.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('plan')->with('error', $th->getMessage());
        }
    }
    // -----------------------------------------
}
