<?php
$user = auth()->user();
$SA = $user->hasRole('SUPER-ADMIN');

$navList = [
    [
        'icon' => 'fa-duotone fa-table-rows',
        'title' => 'Dashboard',
        'url' => 'dashboard',
        'access' => 'user-admin',
    ],
    [
        'icon' => 'fa-duotone fa-users',
        'title' => 'Users',
        'url' => 'dashboard/users',
        'access' => 'admin',
    ],
    [
        'icon' => 'fa-duotone fa-credit-card',
        'title' => 'Subscription',
        'url' => 'dashboard/subscription-history',
        'access' => 'admin',
    ],
    [
        'icon' => 'fa-duotone fa-link-simple',
        'title' => 'Bio Links',
        'url' => 'dashboard/links',
        'access' => 'user-admin',
    ],
    [
        'icon' => 'fa-duotone fa-link-horizontal',
        'title' => 'Short Links',
        'url' => 'dashboard/short-links',
        'access' => 'user-admin',
    ],
    [
        'icon' => 'fa-duotone fa-memo',
        'title' => 'Projects',
        'url' => 'dashboard/project',
        'access' => 'user-admin',
    ],
    [
        'icon' => 'fa-duotone fa-qrcode',
        'title' => 'QR codes',
        'url' => 'dashboard/qrcodes',
        'access' => 'user-admin',
    ],
    [
        'icon' => 'fa-duotone fa-file-user',
        'title' => 'Account',
        'url' => 'dashboard/account/setting',
        'access' => 'user-admin',
    ],
    [
        'icon' => 'fa-duotone fa-tag',
        'title' => $SA ? 'Pricing Plans' : 'Current Plan',
        'url' => $SA ? 'dashboard/plans' : 'dashboard/plan',
        'access' => 'user-admin',
    ],
    [
        'icon' => 'fa-duotone fa-message-captions',
        'title' => 'Testimonials',
        'url' => 'dashboard/testimonials',
        'access' => 'admin',
    ],
    [
        'icon' => 'fa-duotone fa-palette',
        'title' => 'Manage Theme',
        'url' => 'dashboard/themes',
        'access' => 'admin',
    ],
    [
        'icon' => 'fa-duotone fa-money-check-dollar-pen',
        'title' => 'Payment Settings',
        'url' => 'dashboard/payment-settings',
        'access' => 'admin',
    ],
    [
        'icon' => 'fa-duotone fa-gear',
        'title' => 'App Settings',
        'url' => 'dashboard/app-settings',
        'access' => 'admin',
    ],
];
?>

<div id="sidebarContainer" class="rounded-end">
    <a class="sidebar-header" href="/">
        
        <img width="36px" height="36px" class="rounded" src="{{ asset($app->logo) }}" alt="">
        <h5 class="ms-3">{{ $app->title }}</h5>
    </a>

    <div style="height: calc(100% - 58px)" data-simplebar class="scrollbar">
        <div class="sidebar-navlist">
            @foreach ($navList as $item)
                @if ($item['title'] == 'Users' ||
                    $item['title'] == 'Subscription' ||
                    $item['title'] == 'Payment Settings' ||
                    $item['title'] == 'App Settings' ||
                    $item['title'] == 'Manage Theme' ||
                    $item['title'] == 'Testimonials')
                    @role('SUPER-ADMIN')
                        <a href="{{ url($item['url']) }}" class="{{ request()->is($item['url']) ? 'active' : '' }}">
                            <i class="{{ $item['icon'] }}"></i>
                            {{ $item['title'] }}
                        </a>
                    @endrole
                @else
                    <a class="{{ request()->is($item['url']) ? 'active' : '' }}" href="{{ url($item['url']) }}">
                        <i class="{{ $item['icon'] }}"></i>
                        {{ $item['title'] }}
                    </a>
                @endif
            @endforeach

            <a class="dropdown-item logout-button" href="{{ route('logout') }}">
                <i class="fa-duotone fa-right-from-bracket"></i>
                {{ __('Log Out') }}
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-none logout-form">
                @csrf
            </form>
        </div>
    </div>
</div>
