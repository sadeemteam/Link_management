<?php
    $payment_methods = [
        [
            'id'=>'stripe',
            'name'=>'Stripe',
            'method'=>'POST',
            'route'=>'/dashboard/stripe/payment',
            'active'=> 0,
            'logo'=>asset('assets/icons/Stripe.png'),
        ],
        [
            'id'=>'paypal',
            'name'=>'Paypal',
            'method'=>'POST',
            'route'=>'/dashboard/paypal/payment',
            'active'=> 0,
            'logo'=>asset('assets/icons/Paypal.png'),
        ],
        [
            'id'=>'razorpay',
            'name'=>'Razorpay',
            'method'=>'GET',
            'route'=>'/dashboard/razorpay/form',
            'active'=> 0,
            'logo'=>asset('assets/icons/Razorpay.png'),
        ],
        [
            'id'=>'mollie',
            'name'=>'Mollie',
            'method'=>'POST',
            'route'=>'/dashboard/mollie/payment',
            'active'=> 0,
            'logo'=>asset('assets/icons/Mollie.png'),
        ],
        [
            'id'=>'paystack',
            'name'=>'Paystack',
            'method'=>'GET',
            'route'=>'/dashboard/paystack/redirect',
            'active'=> 0,
            'logo'=>asset('assets/icons/Paystack.png'),
        ],
    ];

    foreach ($methods as $method) {
        for ($i = 0; $i < count($payment_methods); $i++) {
            $element = $payment_methods[$i];
            if ($element['id'] == $method->name) {
                $payment_methods[$i]['active'] = $method->active;
                break;
            }
        }
    }
?>

<div class="py-3">
   <h5 class="mb-3" style="color: #667085" >
       <i style="font-size: 16px" class="me-2 fa-solid fa-credit-card-front"></i>
       {{__('Payment method')}}
   </h5>
   
   <div class="row">
    @foreach($payment_methods as $item)
        @if ($item['active'])
        <div class="col-12 col-md-6">
            <div 
                id="{{$item['id']}}" 
                data-info="{{json_encode($item)}}"
                class="card p-4 mb-3 method payment_method"
            >
                <div class="d-flex align-items-center justify-content-between" style="height: 100%">
                    <h4>{{$item['name']}}</h4>
                    <img 
                        src="{{$item['logo']}}" 
                        width="{{$item['name'] == 'Stripe' || $item['name'] == 'Mollie' ? '100' : '44'}}" 
                        alt=""
                    >
                </div>
            </div>
        </div>
        @endif
    @endforeach
   </div>
</div>