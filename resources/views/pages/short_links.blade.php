@extends('layouts.dashboard.dashboard')

<?php
    $user = auth()->user();
?>

@section('content')
<div class="container">
    @error('link_name')
        @include('components.Toast', ['toastType' => 'error', 'message' => $message])
    @enderror
    @error('external_url')
        @include('components.Toast', ['toastType' => 'error', 'message' => $message])
    @enderror

    <div class="d-flex justify-content-between py-4">
        <h5 style="font-size: 22px">{{__('Links')}}</h5>
        <div class="d-flex">
            <button 
                data-bs-toggle="modal" 
                class="btn btn-primary text-white" 
                data-bs-target="{{$limit_over ? '#limitWarning' : '#createShortLink'}}"
            >
                <i class="fa-solid fa-circle-plus" style="font-size: 14px" ></i>
                {{__('Short-Link')}}
            </button>
        </div>

        @include('components.links.CreateShortLink')
    </div>

    @if($limit_over)
        @include('components.common.WarningAlert')
    @endif

    @if(count($links) > 0)
        
        <div class="card overflow-auto">           
            <table class="table table-borderless styled-table">
                <thead>
                    <tr>
                        <th scope="col">{{__('Link Url')}}</th>
                        <th scope="col" class="text-center">{{__('Link Name')}}</th>
                        <th scope="col" class="text-center">{{__('Total Views')}}</th>
                        <th scope="col" class="text-center">{{__('QR Code')}}</th>
                        <th scope="col" class="text-center">{{__('Copy Link')}}</th>
                        <th scope="col" class="text-end">{{__('Action')}}</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($links as $link)
                        <tr>
                            <td class="align-middle"> 
                                <a class="textPrimary" id="linkUrl{{$link->id}}" target="_blank" href="/{{$link->url_name}}">
                                    {{url($link->url_name)}}
                                </a>
                            </td>

                            <td class="text-center align-middle visited"> 
                                <p class="m-0">{{$link->link_name}}</p>
                            </td>

                            <td class="text-center align-middle visited"> 
                                <a href="/dashboard/biolink/analytics/{{$link->id}}/overview">
                                    <span>
                                        <i class="fa-solid fa-chart-line"></i> 
                                        {{count($link->visited)}}
                                    </span>
                                </a>
                            </td>

                            <td class="text-center align-middle">
                                @if($link->qrcode_id)
                                    <img width="40px" src="{{$link->qrcode->img_data}}" alt="...">
                                @else
                                    <button 
                                        type="submit" 
                                        class="btn linkQRCode" 
                                        style="
                                            font-size: 13px;
                                            background: #ebedef;
                                            padding: 1px 6px;
                                            font-weight: 500;
                                        " 
                                        data-link="{{json_encode($link)}}"
                                    >
                                        {{__('Create QR')}}
                                    </button>
                                @endif
                            </td>

                            <td class="text-center align-middle visited"> 
                                <span 
                                    id="linkCopy{{$link->id}}" 
                                    onclick="makeCopy('linkCopy{{$link->id}}', 'linkUrl{{$link->id}}')"
                                >
                                    {{__('Copy')}}
                                </span>
                            </td>

                            <td class="align-middle d-flex justify-content-end">
                                <button 
                                    class="btn link-control" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editShortLink{{$link->id}}"
                                >
                                    <i class="fa-duotone fa-pen-circle"></i>
                                </button>
                                <button 
                                    class="btn link-control" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteItem{{$link->id}}"
                                >
                                    <i class="fa-duotone fa-circle-trash text-danger"></i>
                                </button>

                                @include('components.DeletePopup', [
                                    'id' => $link->id, 
                                    'action' => "/dashboard/delete-link/".$link->id
                                ])

                                @include('components.links.EditShortLink')
                            </td>
                        </tr>
                    @endforeach

                    @include('components.links.LinkQRCode')
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center">
                {{ $links->links() }}
            </div>
        </div>
    @else
        <div class="card py-4 px-3 shadow-sm border-0 text-center">
            <h5>{{__('No have any project')}}</h5>
        </div>
    @endif

    <script>
        function makeCopy (linkCopy, linkUrl) {
            const result = window.copyAnchorHref(linkUrl);
            document.getElementById(linkCopy).innerText = result;
            setTimeout(()=> {
                document.getElementById(linkCopy).innerText = "Copy";
            }, 1000)
        }
    </script>
</div>
@endsection
