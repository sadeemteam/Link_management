@extends('layouts.dashboard.dashboard')

@section('content')
<div class="container">
    <div class="py-4">
        <h5 style="font-size: 22px">{{__('App Settings')}}</h5>
    </div>

    <div class="mb-5">
        @include('components.settings.AppSettings')
    </div>

    <div class="mb-5">
        @include('components.settings.GoogleLogin')
    </div>

    <div class="mb-5">
        @include('components.settings.SetupSMTP')
    </div>
</div>
@endsection