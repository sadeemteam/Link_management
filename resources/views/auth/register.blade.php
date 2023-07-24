@extends('auth.layout')

<?php
    $urlName = preg_replace("/\s+/", "", strtolower(request()->linkname));
    $iconClass = 'input-group-text bg-white ps-3 border';
    $inputClass = 'form-control px-2 border-start-0 rounded-end';
?>

@section('content')
<div class="container">
    <div class="row align-items-center justify-content-center" style="height: 100vh">
        <div class="col-lg-8">
            <div class="card">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="auth-form-sidebar">
                            <img height="142px" width="142px" src="{{asset($app->logo)}}" alt="">
                            <h5 class="fw-bold mt-4">{{$app->title}}</h5>
                        </div>
                    </div>
    
                    <div class="col-lg-7">
                        <form class="auth-form pb-0" method="POST" action="{{ route('register') }}">
                            @csrf

                            <h5 class="mb-4">
                                <a class="text-decoration-none" href="{{ route('login') }}">
                                    <span style="color: #98A2B3">{{__('Log in')}} |</span>
                                </a>
                                <a class="text-decoration-none" style="color: #1D2939" href="{{ route('register') }}">
                                    {{__('Register')}}
                                </a>
                            </h5>
                            
                            <div class="input-group mb-4">
                                <span class="{{$iconClass}} @error('name') border-danger @enderror">
                                    <i class="fa-regular fa-user"></i>
                                </span>
                                <input 
                                    required 
                                    name="name" 
                                    placeholder="Your Name" 
                                    value="{{ old('name') }}" 
                                    class="{{$inputClass}} @error('name') is-invalid @enderror"
                                >
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="input-group mb-4">
                                <span class="{{$iconClass}} @error('url_name') border-danger @enderror">
                                    <i class="fa-regular fa-user"></i>
                                </span>
                                <span class="input-group-text border-start-0 bg-white pe-0 @error('url_name') border-danger @enderror">
                                    /
                                </span>
                                <input 
                                    required 
                                    id="bioLinkName"
                                    name="url_name"
                                    placeholder="urlname" 
                                    value="{{$urlName ? $urlName : ''}}"
                                    class="ps-0 {{$inputClass}} @error('url_name') is-invalid @enderror"
                                >
                                @error('url_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <script>
                                    document.getElementById("bioLinkName")
                                    .addEventListener("change", function (item) {
                                        let result = item.target.value.replace(/\s+/g, '').toLowerCase();
                                        item.target.value = result;
                                    });
                                </script>
                            </div>
    
                            <div class="input-group mb-4">
                                <span class="{{$iconClass}} @error('email') border-danger @enderror">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                                <input 
                                    required 
                                    name="email" 
                                    type="email" 
                                    placeholder="Your Email" 
                                    value="{{ old('email') }}" 
                                    class="{{$inputClass}} @error('email') is-invalid @enderror"
                                >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="input-group mb-4">
                                <span class="{{$iconClass}} @error('password') border-danger @enderror">
                                    <i class="fa-regular fa-lock-keyhole"></i>
                                </span>

                                <input 
                                    required 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    placeholder="Password" 
                                    autocomplete="new-password"
                                    class="{{$inputClass}} @error('password') is-invalid @enderror" 
                                >
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="input-group mb-4">
                                <span class="input-group-text bg-white ps-3">
                                    <i class="fa-regular fa-lock-keyhole"></i>
                                </span>
                                <input 
                                    type="password" 
                                    id="password-confirm" 
                                    name="password_confirmation" 
                                    placeholder="Confirm Password" 
                                    required autocomplete="new-password"
                                    class="form-control px-2 border-start-0" 
                                >
                            </div>
    
                            <button type="submit" class="form-control btn btn-primary text-white mb-3">
                                {{ __('Register') }}
                            </button>
                        </form>

                        <form action="auth/google" method="GET" class="auth-form pt-0">
                            @csrf

                            @if ($google->active)
                                <button type="submit" class="form-control d-flex align-items-center justify-content-center">
                                    <img src="{{asset('assets/icons/google.svg')}}" alt="" class="me-2">
                                    {{__('Continue with Google')}}
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
