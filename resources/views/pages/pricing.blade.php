@extends('layouts.dashboard.dashboard')

@section('content')
<div class="container pricing">
    <div class="d-flex justify-content-between py-4">
        <h5 style="font-size: 22px">{{__('Pricing Plans')}}</h5>
    </div>

    <div class="row">
        @foreach($plans as $plan)
            <?php
                $user = auth()->user();
                $activePlan = $plan->name == 'STANDARD' ? 'border border-2 border-primary' : '';
                $btnStyle = $plan->name == 'STANDARD' ? 'btn-primary text-white' : 'btn-outline-secondary'
            ?>
            <div class="col-lg-4 p-3">
                <div class="card {{$activePlan}} h-100">
                    <div class="p-4">
                        <span class="rounded-pill {{$plan->name}}">{{$plan->name}}</span>

                        @if($plan->name == 'BASIC')
                            <h1 class="fw-bold pt-3 pb-2" style="font-size: 36px">{{__('Free')}}</h1>
                        @else
                            <h1 class="fw-bold pt-3 pb-2 price_title" style="font-size: 36px">
                                @if($plan->monthly_plan_id)
                                    <span>${{$plan->monthly_price}}</span>
                                @else
                                    <span>${{$plan->yearly_price}}</span>
                                @endif
                                
                                <select class="fw-normal border border-0" style="font-size: 14px">
                                    @if($plan->monthly_plan_id)
                                        <option value="${{$plan->monthly_price}}">/month</option>
                                    @endif
                                    @if($plan->yearly_plan_id)
                                        <option value="${{$plan->yearly_price}}">/yearly</option>
                                    @endif
                                </select>
                            </h1>
                        @endif
                        
                        <p style="font-size: 14px">{{$plan->description}}</p>
                    </div> 
    
                    <div class="border-top"></div>
    
                    <div class="p-4 styled-pricing-list">
                        <h6 class="fw-bolder pb-2">{{__('Include')}}</h6>
                        <ul class="list-unstyled">
                            @foreach($plan->plan_items as $item)
                                <li>
                                    <i class="fa-solid fa-badge-check"></i>
                                    {{$item['quantity']}} {{$item['title']}}
                                </li>
                            @endforeach
                        </ul>

                        @if($user->pricing_plan->name == $plan->name)
                            @if($plan->name == 'BASIC')
                                <button 
                                    class="form-control btn {{$btnStyle}}"
                                    disabled
                                >
                                    {{__('Choose Plan')}}
                                </button>
                            @else
                                <a 
                                    type="button" 
                                    href="/dashboard/billing/{{$plan->id}}"
                                    class="form-control btn {{$btnStyle}}"
                                >
                                    {{__('Choose Plan')}}
                                </a>
                            @endif
                        @else
                            <a 
                                type="button" 
                                href="/dashboard/billing/{{$plan->id}}"
                                class="form-control btn {{$btnStyle}}"
                            >
                                {{__('Choose Plan')}}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection