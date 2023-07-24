@extends('layouts.dashboard.dashboard')

@section('content')
    <div class="container py-3 linkItemEditor">
        <div class="row">
            <div class="col-lg-7">
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <div class="add-link">
                        <h4 style="font-size: 24px">{{$link->link_name}}</h4>
                    
                        <p class="link-title">
                            {{__('Your link is :')}}
                            <a 
                                target="_blank" class="px-1" 
                                href="/{{$link->url_name}}" 
                            >
                                {{$link->url_name}}
                            </a>
                        </p>
                    </div>
                </div>
                {{-- {{$themes}} --}}
                @include('components.link_items.LinkItemTab')
            </div>

            <div class="d-none d-lg-block col-lg-5">
                <div class="mobileLinkContainer">
                    @include('components.link_items.LinkView')
                </div>
            </div>
        </div>
    </div>
@endsection
