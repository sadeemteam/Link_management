<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $app->title }} - {{__('Your Link Management in one place')}}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/toastify.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('splide/splide.min.js') }}"></script>
    <script src="{{ asset('js/qr-code-styling.js') }}"></script>
    <script src="{{ asset('/js/apexcharts.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome.js') }}" ></script>
    <script src="{{ asset('js/simplebar.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
 
    {{-- Scrollbar --}}
    <link rel="stylesheet" href="{{ asset('css/simplebar.css') }}" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('splide/splide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/drag&drop.css') }}">
</head>

<body>
    <div id="preloader">
        <div id="loader"></div>
    </div>
    <div class="dashboard">
        <div class="dashboard-sidebar d-none d-lg-block">
            @include('layouts.dashboard.sidebar')
        </div>
        <div class="dashboard-sidebar dashboard-sidebar-mobile d-block d-lg-none" id="mobileSidebar">
            @include('layouts.dashboard.mobile_sidebar')
        </div>

        <div class="dashboard-content">
            @include('layouts.dashboard.header')
            <main class="content-area d-flex flex-column justify-content-between">
                <div>
                    @if (session('error'))
                    @include('components.Toast', ['toastType' => 'error', 'message' => session('error')])
                    @endif
                    @if (session('success'))
                        @include('components.Toast', ['toastType' => 'success', 'message' => session('success')])
                    @endif
                    <div class="container">
                        @include('components.common.PaymentWarning')
                    </div>

                    @yield('content')
                </div>

                <div class="container pt-4 px-2 text-center">
                    <p style="font-size: 12px;">{{$app->copyright}}</p>
                </div>
            </main>
        </div>
    </div>


    <script src="{{ asset('js/utils.js') }}"></script>
    <script src="{{ asset('js/link-setting.js') }}"></script>
    <script src="{{ asset('js/qrcode-custom.js') }}"></script>
    <script src="{{ asset('js/link-items-add.js') }}"></script>
    <script src="{{ asset('js/payment.js') }}"></script>
    <script src="{{ asset('js/dashboardscript.js') }}"></script>
    <script src="{{ asset('js/account.js') }}"></script>

    <script>
        Array.prototype.forEach.call(
            document.querySelectorAll('.scrollbar'),
            el => new SimpleBar(el)
        );

        const logOutButtons = document.querySelectorAll(".logout-button");
        if (logOutButtons && logOutButtons.length > 0) {
            logOutButtons.forEach((item) => {
                item.addEventListener("click", (e) => {
                    e.preventDefault(); 
                    document.querySelector('.logout-form').submit();
                });
            });
        }

    </script>
</body>

</html>
