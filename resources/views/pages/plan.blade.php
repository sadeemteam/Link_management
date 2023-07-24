@extends('layouts.dashboard.dashboard')
<?php $user = auth()->user();?>

@section('content')
<div class="container pricing">
    <div class="d-flex justify-content-between py-4">
        <h5 style="font-size: 22px">{{__('Current Plan')}}</h5>
    </div>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 p-3">
            <div class="card border border-2 border-primary">
                <div class="p-4">
                    <span class="rounded-pill {{$plan->name}}">
                        {{$plan->name}}
                    </span>

                    @if($plan->name == 'BASIC')
                        <h1 class="fw-bold pt-3 pb-2" style="font-size: 36px">{{__('Free')}}</h1>
                    @else
                        @if($user->recurring == 'monthly')
                            <h1 class="fw-bold pt-3 pb-2" style="font-size: 36px">
                                {{$plan->monthly_price}}
                                <span class="fw-normal" style="font-size: 14px">
                                    {{$plan->currency}} /monthly
                                </span>
                            </h1>
                        @else
                            <h1 class="fw-bold pt-3 pb-2" style="font-size: 36px">
                                {{$plan->yearly_price}}
                                <span class="fw-normal" style="font-size: 14px">
                                    {{$plan->currency}} /yearly
                                </span>
                            </h1>
                        @endif
                    @endif
                    
                    <p style="font-size: 14px">{{$plan->description}}</p>
                </div> 

                <div class="border-top"></div>

                <div class="p-4 styled-pricing-list">
                    <h6 class="fw-bolder pb-2">{{__('Include')}}</h6>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa-solid fa-badge-check"></i>
                            {{$plan->biolinks}} Biolinks Create
                        </li>
                        <li>
                            <i class="fa-solid fa-badge-check"></i>
                            {{$plan->biolink_blocks}} Biolink Blocks Access
                        </li>
                        <li>
                            <i class="fa-solid fa-badge-check"></i>
                            {{$plan->shortlinks}} Shortlinks Create
                        </li>
                        <li>
                            <i class="fa-solid fa-badge-check"></i>
                            {{$plan->projects}} Projects Create
                        </li>
                        <li>
                            <i class="fa-solid fa-badge-check"></i>
                            {{$plan->qrcodes}} QRCodes Create
                        </li>
                        <li>
                            <i class="fa-solid fa-badge-check"></i>
                            {{$plan->themes}} Theme Access
                        </li>
                        <li>
                            <i class="fa-solid fa-badge-check"></i>
                            {{$plan->custom_theme ? 'Custom Theme Create Allow' : 'Custom Theme Create Not Allow'}}
                        </li>
                        <li>
                            <i class="fa-solid fa-badge-check"></i>
                            {{$plan->support}} Hours Support
                        </li>
                    </ul>

                    <a 
                        class="form-control type-button btn btn-primary text-white" 
                        href="{{route('plan-update')}}"
                    >
                        {{__('Update Plan')}}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>
@endsection