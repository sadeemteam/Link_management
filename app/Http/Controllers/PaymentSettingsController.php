<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
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
            $stripe = PaymentGateway::where('name', 'stripe')->first();
            $razorpay = PaymentGateway::where('name', 'razorpay')->first();
            $paypal = PaymentGateway::where('name', 'paypal')->first();
            $mollie = PaymentGateway::where('name', 'mollie')->first();
            $paystack = PaymentGateway::where('name', 'paystack')->first();

            return view('pages.admin.payment-settings', compact('stripe', 'razorpay', 'paypal', 'mollie', 'paystack'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }


    // Stripe payment gateway settings for admin
    public function stripe_update(Request $request) 
    {
        $request->validate([
            'stripe_key' => 'required',
            'stripe_secret' => 'required',
        ]);
        $allow_stripe = $request->allow_stripe ? true : false;

        try {
            PaymentGateway::where('name', 'stripe')->update([
                'active' => $allow_stripe,
                'key' => $request->stripe_key,
                'secret' => $request->stripe_secret,
            ]);

            return back()->with('success', 'Stripe successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    // Stripe payment gateway settings for admin
    public function razorpay_update(Request $request) 
    {
        $request->validate([
            'razorpay_key' => 'required',
            'razorpay_secret' => 'required',
        ]);
        $allow_razorpay = $request->allow_razorpay ? true : false;

        try {
            PaymentGateway::where('name', 'razorpay')->update([
                'active' => $allow_razorpay,
                'key' => $request->razorpay_key,
                'secret' => $request->razorpay_secret,
            ]);
            
            return back()->with('success', 'Razorpay successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    // Stripe payment gateway settings for admin
    public function paypal_update(Request $request) 
    {
        $request->validate([
            'paypal_client_id' => 'required',
            'paypal_client_secret' => 'required',
        ]);
        $allow_paypal = $request->allow_paypal ? true : false;

        try {
            PaymentGateway::where('name', 'paypal')->update([
                'active' => $allow_paypal,
                'key' => $request->paypal_client_id,
                'secret' => $request->paypal_client_secret,
            ]);

            return back()->with('success', 'Paypal successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    // Stripe payment gateway settings for admin
    public function mollie_update(Request $request) 
    {
        $request->validate([
            'mollie_key' => 'required',
        ]);
        $allow_mollie = $request->allow_mollie ? true : false;

        try {
            PaymentGateway::where('name', 'mollie')->update([
                'active' => $allow_mollie,
                'key' => $request->mollie_key,
            ]);

            return back()->with('success', 'Mollie successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    // Stripe payment gateway settings for admin
    public function paystack_update(Request $request) 
    {
        $request->validate([
            'paystack_key' => 'required',
            'paystack_secret' => 'required',
        ]);
        $allow_paystack = $request->allow_paystack ? true : false;

        try {
            PaymentGateway::where('name', 'paystack')->update([
                'active' => $allow_paystack,
                'key' => $request->paystack_key,
                'secret' => $request->paystack_secret,
            ]);

            return back()->with('success', 'Paystack successfully updated.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
