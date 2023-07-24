@extends('layouts.dashboard.dashboard')
<?php $user = auth()->user();?>

@section('content')
<div class="container payment">
    <div class="d-flex justify-content-between py-4">
        <h5 style="font-size: 22px">{{__('Payment Information')}}</h5>
    </div>

    <div class="row pb-3">
        <div class="col-lg-8">
            @include('components.subscription_type.PaymentMethod')
        </div>
        <div class="col-lg-4 pricing">            
            @include('components.subscription_type.OrderSummery')

            <form id="checkoutForm">
                @csrf

                <input type="hidden" name="billing_type" value="{{$type}}">
                <input type="hidden" name="plan_id" value="{{$plan->id}}">

                <button 
                    id="checkout" 
                    type="submit"
                    class="btn btn-primary text-white form-control"
                >
                    {{__('Checkout')}}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection