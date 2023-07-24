@extends('layouts.dashboard.dashboard')

@section('content')
<div class="container">
    <div class="py-4">
        <h5 style="font-size: 22px">{{__('App Settings')}}</h5>
    </div>

    <div class="mb-4">
        @include('components.settings.SetupStripe')
    </div>
    <div class="mb-4">
        @include('components.settings.SetupRazorpay')
    </div>
    <div class="mb-4">
        @include('components.settings.SetupPaypal')
    </div>
    <div class="mb-4">
        @include('components.settings.SetupMollie')
    </div>
    <div class="mb-4">
        @include('components.settings.SetupPaystack')
    </div>
</div>
@endsection