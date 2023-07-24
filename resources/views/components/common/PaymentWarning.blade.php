@php
    $user = auth()->user();
@endphp
@if (isset($next_payment) && $next_payment)
    <div class="alert alert-danger" role="alert">
        {{__('Your subscription is over now. Please complete your payment before use app more')}} 
        <a href="{{route('billing', ['id'=>$user->pricing_plan->id, 'type'=>$user->recurring])}}">
            {{__('payment')}}
        </a>
    </div>
@endif