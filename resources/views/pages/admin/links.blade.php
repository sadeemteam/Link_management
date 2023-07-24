@extends('layouts.dashboard.dashboard')

<?php
    $user = auth()->user();
?>

@section('content')
<div class="container">
    @error('name')
        @include('components.Toast', ['toastType' => 'error', 'message' => $message])
    @enderror
  
    @error('url_name')
        @include('components.Toast', ['toastType' => 'error', 'message' => $message])
    @enderror

    <div class="d-flex justify-content-between py-4">
        <h5 style="font-size: 22px">{{__('Links')}}</h5>
        <button 
            data-bs-toggle="modal" 
            class="btn btn-primary text-white px-4" 
            data-bs-target="#createLink"
        >
            <i class="fa-solid fa-circle-plus" style="font-size: 14px" ></i>
            {{__('Create Link')}}
        </button>

        @include('components.links.CreateLink')
    </div>

    @if(count($links) > 0)
        <div class="card overflow-auto">           
            <table class="table table-borderless styled-table">
                <thead>
                    <tr>
                        <th scope="col" class="">{{__('Link Name')}}</th>
                        <th scope="col" class="text-center">{{__('Customize Link')}}</th>
                        <th scope="col" class="text-center">{{__('Views Link')}}</th>
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
                                <span>
                                    {{$link->link_name}}
                                </span>
                            </td>

                            <td class="text-center align-middle visited"> 
                                <a href="/dashboard/biolink/{{$link->url_name}}">
                                    {{__('Customize')}}
                                </a>
                            </td>

                            <td class="text-center align-middle visited"> 
                                <a id="linkUrl{{$link->id}}" target="_blank" href="/{{$link->url_name}}">
                                    {{__('Visit Link')}}
                                </a>
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
                                <?php
                                    $editPopup;
                                    if ($link->link_type == 'biolink') {
                                        $editPopup = "#editLink{$link->id}";
                                    } else {
                                        $editPopup = "#editShortLink{$link->id}";
                                    }
                                ?>
                                <button 
                                    class="btn link-control" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="{{$editPopup}}"
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

                                @include('components.links.EditLink')
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
        function makeCopy(linkCopy, linkUrlID) {
            // console.log(linkUrl);
            const result = window.copyAnchorHref(linkUrlID);
            document.getElementById(linkCopy).innerText = result;
            setTimeout(() => {
                document.getElementById(linkCopy).innerText = "Copy";
            }, 1000)
        }
    </script>
</div>
@endsection
