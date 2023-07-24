<?php
$user = Auth::user();
?>
<nav class="dashboard-navbar m-3 mb-0 rounded-3">
    <div class="container py-1 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <button class="btn d-block d-lg-none" id="expandSidebar">
                <img width="20" height="20" src="{{ asset('assets/icons/menu.svg') }}" />
            </button>
            <h5 class="d-none d-lg-block">{{ ucfirst($user->name) }}</h5>
        </div>

        <div class="dropdown">
            <a 
                v-pre
                href="#" 
                role="button" 
                id="navbarDropdown" 
                class="me-3 me-lg-0" 
                data-bs-toggle="dropdown"
                aria-haspopup="true" 
                aria-expanded="false" 
            >
                <img 
                    width="40px" 
                    height="40px" 
                    class="rounded-circle" 
                    src="{{ $user->image ? asset($user->image) : asset('assets/user-profile.png') }}"
                >
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <p class="dropdown-item">{{ Auth::user()->name }}</p>
                <a class="dropdown-item" href="/">
                    {{__('Home')}}
                </a>
                <a class="dropdown-item logout-button" href="{{ route('logout') }}">
                    {{ __('Logout') }}
                </a>

                <form action="{{ route('logout') }}" method="POST" class="d-none logout-form">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
