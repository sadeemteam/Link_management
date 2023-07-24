@extends('auth.layout')

<?php
$iconClass = 'input-group-text bg-white ps-3';
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
                                <img height="142px" width="142px" src="{{ asset($app->logo) }}" alt="">
                                <h5 class="fw-bold mt-4">{{$app->title}}</h5>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <form 
                                method="POST" 
                                class="auth-form pb-0" 
                                action="{{ route('login') }}"
                            >
                                @csrf

                                <h5 class="mb-4">
                                    <a class="text-decoration-none" style="color: #1D2939" href="{{ route('login') }}">
                                        {{__('Log in')}} |
                                    </a>
                                    <a class="text-decoration-none" href="{{ route('register') }}">
                                        <span style="color: #98A2B3">{{__('Register')}}</span>
                                    </a>
                                </h5>
                                <div class="input-group mb-4">
                                    <span class="{{ $iconClass }} @error('email') border-danger @enderror">
                                        <i class="fa-regular fa-envelope"></i>
                                    </span>
                                    <input required id="email" name="email" type="email" value="{{ old('email') }}"
                                        placeholder="Email Address"
                                        class="{{ $inputClass }} @error('email') is-invalid @enderror">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }} </strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <span class="{{ $iconClass }} @error('password') border-danger @enderror">
                                        <i class="fa-regular fa-lock-keyhole"></i>
                                    </span>
                                    <input required id="password" type="password" name="password" placeholder="Password"
                                        class="{{ $inputClass }} @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-2 mb-3"
                                    style="font-size: 14px">
                                    <div class="form-check">
                                        <input name="remember" type="checkbox" class="form-check-input" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a class="text-danger text-decoration-none" href="{{ route('password.request') }}"
                                            style="font-size: 14px">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>

                                <button type="submit" class="form-control btn btn-primary text-white mb-3">
                                    {{ __('Login') }}
                                </button>
                            </form>

                            <form action="auth/google" method="GET" class="auth-form pt-0">
                                @csrf

                                @if ($google->active)
                                    <button type="submit" class="form-control d-flex align-items-center justify-content-center mb-3">
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
