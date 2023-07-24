@extends('layouts.dashboard.dashboard')
<?php
$active = request('activeElement');
?>

@section('content')
    <div class="container py-3 account">
        <h4 class="mb-5" style="font-size: 24px">{{__('Account')}}</h4>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link me-4 {{ $active == 'setting' ? 'active' : 'inactive' }}"
                            data-bs-toggle="pill" data-bs-target="#pills-setting" aria-selected="true"
                            onclick="navigate('/dashboard/account/setting')">
                            {{__('Setting')}}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link me-4 {{ $active == 'email' ? 'active' : 'inactive' }}" data-bs-toggle="pill"
                            data-bs-target="#pills-email" aria-selected="false"
                            onclick="navigate('/dashboard/account/email')">
                            {{__('Change Email')}}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link me-4 {{ $active == 'password' ? 'active' : 'inactive' }}"
                            data-bs-toggle="pill" data-bs-target="#pills-password" aria-selected="false"
                            onclick="navigate('/dashboard/account/password')">
                            {{__('Change Password')}}
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="card tab-pane fade {{ $active == 'setting' ? 'show active' : '' }}" id="pills-setting">
                        @include('components.account.Setting')
                    </div>
                    <div class="card tab-pane fade {{ $active == 'email' ? 'show active' : '' }}" id="pills-email">
                        @include('components.account.ResetEmail')
                    </div>
                    <div class="card tab-pane fade {{ $active == 'password' ? 'show active' : '' }}" id="pills-password">
                        @include('components.account.ResetPassword')
                    </div>
                </div>
            </div>
        </div>

        <script>
            function navigate(value) {
                window.location.href = value;
            }
        </script>
    </div>
@endsection
