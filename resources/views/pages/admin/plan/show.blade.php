@extends('layouts.dashboard.dashboard')

@section('content')
    <div class="container pricing">
        <div class="d-flex justify-content-between py-4">
            <h5 style="font-size: 22px">{{__('Pricing Plans')}}</h5>

            <a 
                href="{{route('plan.create')}}"
                class="btn btn-primary text-white px-4" 
            >
                <i class="fa-solid fa-circle-plus" style="font-size: 14px" ></i>
                {{__('Create New Plan')}}
            </a>
        </div>

        <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button 
                    role="tab" 
                    type="button" 
                    id="pills-home-tab" 
                    aria-selected="true"
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-home" 
                    aria-controls="pills-home" 
                    class="nav-link active" 
                >
                    Monthly
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button 
                    role="tab" 
                    type="button" 
                    class="nav-link" 
                    id="pills-profile-tab" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-profile" 
                    aria-controls="pills-profile" 
                    aria-selected="false"
                >
                    Yearly
                </button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="row">
                    @foreach ($plans as $plan)
                    <div class="col-lg-4 p-3">
                        <div class="card position-relative">
                            <span 
                                class="badge text-capitalize rounded-pill position-absolute @if($plan->status == 'active') text-bg-success @else text-bg-danger @endif" 
                                style="top: 10px; right: 10px;"
                            >
                                {{$plan->status}}
                            </span>
                            <div class="p-4">
                                <span class="rounded-pill {{$plan->name}}">
                                    {{$plan->name}}
                                </span>
            
                                @if($plan->name == 'BASIC')
                                    <h1 class="fw-bold pt-3 pb-2" style="font-size: 36px">{{__('Free')}}</h1>
                                @else
                                    <h1 class="fw-bold pt-3 pb-2" style="font-size: 36px">
                                        {{$plan->monthly_price}}
                                        <span class="fw-normal" style="font-size: 14px">
                                            {{$plan->currency}} /monthly
                                        </span>
                                    </h1>
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
                                    href="{{route('plan.update', $plan->id)}}"
                                >
                                    {{__('Edit Plan')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <div class="row">
                    @foreach ($plans as $plan)
                    <div class="col-lg-4 p-3">
                        <div class="card position-relative">
                            <span 
                                class="badge text-capitalize rounded-pill position-absolute @if($plan->status == 'active') text-bg-success @else text-bg-danger @endif" 
                                style="top: 10px; right: 10px;"
                            >
                                {{$plan->status}}
                            </span>
                            <div class="p-4">
                                <span class="rounded-pill {{$plan->name}}">
                                    {{$plan->name}}
                                </span>
            
                                @if($plan->name == 'BASIC')
                                    <h1 class="fw-bold pt-3 pb-2" style="font-size: 36px">{{__('Free')}}</h1>
                                @else
                                    <h1 class="fw-bold pt-3 pb-2" style="font-size: 36px">
                                        {{$plan->yearly_price}}
                                        <span class="fw-normal" style="font-size: 14px">
                                            {{$plan->currency}} /yearly
                                        </span>
                                    </h1>
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
                                    href="{{route('plan.update', $plan->id)}}"
                                >
                                    {{__('Edit Plan')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection