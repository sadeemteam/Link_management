@extends('layouts.dashboard.dashboard')
<?php
    $active = request('statistics');
?>

@section('content')
    <div class="container py-3 analytics">
        <ul class="nav nav-pills mb-3 justify-content-between" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button 
                    data-bs-toggle="pill" 
                    class="nav-link {{$active == 'overview' ? 'active' : 'inactive';}}" 
                    data-bs-target="#pills-overview" 
                    aria-selected="true"
                    onclick="activeStatistic('{{$link->id}}', 'overview')"
                >
                    {{__('Overview')}}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link {{$active == 'countries' ? 'active' : 'inactive';}}" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-countries" 
                    aria-selected="false"
                    onclick="activeStatistic('{{$link->id}}', 'countries')"
                >
                    {{__('Countries')}}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link {{$active == 'referrers' ? 'active' : 'inactive';}}" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-referrers" 
                    aria-selected="false"
                    onclick="activeStatistic('{{$link->id}}', 'referrers')"
                >
                    {{__('Referrers')}}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link {{$active == 'devices' ? 'active' : 'inactive';}}" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-devices" 
                    aria-selected="false"
                    onclick="activeStatistic('{{$link->id}}', 'devices')"
                >
                    {{__('Devices')}}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link {{$active == 'operating-systems' ? 'active' : 'inactive';}}" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-operating-systems" 
                    aria-selected="false"
                    onclick="activeStatistic('{{$link->id}}', 'operating-systems')"
                >
                    {{__('Operating Systems')}}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link {{$active == 'browsers' ? 'active' : 'inactive';}}" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-browsers" 
                    aria-selected="false"
                    onclick="activeStatistic('{{$link->id}}', 'browsers')"
                >
                    {{__('Browsers')}}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link {{$active == 'languages' ? 'active' : 'inactive';}}" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-languages" 
                    aria-selected="false"
                    onclick="activeStatistic('{{$link->id}}', 'languages')"
                >
                    {{__('Languages')}}
                </button>
            </li>
        </ul>
        
        <div class="tab-content" id="pills-tabContent">
            <div 
                id="pills-overview" 
                class="tab-pane fade {{$active == 'overview' ? 'show active' : '';}}" 
            >
                @include('components.biolink_analytics.Overview')
            </div>
            <div 
                id="pills-countries" 
                class="tab-pane fade {{$active == 'countries' ? 'show active' : '';}}" 
            >
                @include('components.biolink_analytics.Countries')
            </div>
            <div 
                id="pills-referrers" 
                class="tab-pane fade {{$active == 'referrers' ? 'show active' : '';}}" 
            >
                @include('components.biolink_analytics.Referrers')
            </div>
            <div 
                id="pills-devices" 
                class="tab-pane fade {{$active == 'devices' ? 'show active' : '';}}" 
            >
                @include('components.biolink_analytics.Devices')
            </div>
            <div 
                id="pills-operating-systems" 
                class="tab-pane fade {{$active == 'operating-systems' ? 'show active' : '';}}" 
            >
                @include('components.biolink_analytics.OperatingSystems')
            </div>
            <div 
                id="pills-browsers" 
                class="tab-pane fade {{$active == 'browsers' ? 'show active' : '';}}" 
            >
                @include('components.biolink_analytics.Browsers')
            </div>
            <div 
                id="pills-languages" 
                class="tab-pane fade {{$active == 'languages' ? 'show active' : '';}}" 
            >
                @include('components.biolink_analytics.Languages')
            </div>
        </div>
    </div>

    <script>
        function activeStatistic(id, path){
            window.location.href = `/dashboard/biolink/analytics/${id}/${path}`;
        }
    </script>
    
@endsection
