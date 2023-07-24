@extends('layouts.dashboard.dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between py-4">
            <h5 style="font-size: 22px">{{__('QR Code List')}}</h5>
            <button 
                data-bs-toggle="modal" 
                class="btn btn-primary px-4" 
                data-bs-target="{{$limit_over ? '#limitWarning' : ''}}"
            >
                <a 
                    class="w-100 h-100 text-white text-decoration-none" 
                    href="{{$limit_over ? '#' : '/dashboard/create-qrcode'}}"
                >
                    <i class="fa-solid fa-circle-plus" style="font-size: 14px" ></i>
                    {{__('Create QR Code')}}
                </a>
            </button>

            @include('components.common.LimitWarning')
        </div>

        @if($limit_over)
            @include('components.common.WarningAlert')
        @endif

        @if(count($qrcodes) > 0)
            <div class="card overflow-auto">
                <table class="table table-borderless styled-table">
                    <thead>
                        <tr>
                            <th scope="col form-check">
                                <label class="form-check-label">
                                    {{__('QR Code')}}
                                </label>
                            </th>
                            <th scope="col" class="text-center">{{__('Project Name')}}</th>
                            <th scope="col" class="text-center">{{__('Link Name')}}</th>
                            <th scope="col" class="text-center">{{__('Publish Date')}}</th>
                            <th scope="col" class="text-end">{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qrcodes as $qrcode)
                            <tr>
                                <th scope="row" class="align-middler">
                                    <img width="40px" src="{{$qrcode->img_data}}" alt="...">
                                </th>
                                <td class="text-center align-middle">
                                    @if($qrcode->project_id)
                                        <span>{{$qrcode->project->project_name}}</span>
                                    @else
                                        <span>{{__('Empty')}}</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    @if($qrcode->link_id)
                                        @if($qrcode->link->link_type == 'biolink')
                                            <span>{{$qrcode->link->link_name}}</span>
                                        @else
                                            <span>{{__('Shorten Link')}}</span>
                                        @endif
                                    @else
                                        <span>{{__('Empty')}}</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <span>{{$qrcode->created_at->format('d M, y')}}</span>
                                </td>

                                <td class="align-middle d-flex align-items-center justify-content-end">
                                    <div class="dropdown me-2" style="max-width: 100px;">
                                        <button 
                                            class="btn btn-sm py-0" 
                                            style="font-size: 20px;"
                                            data-bs-toggle="dropdown" 
                                        >
                                            <i class="fa-solid fa-down-to-line" style="font-size: 18px;"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li onclick="qrcodeDownload('{{$qrcode->img_data}}', 'jpeg')">
                                                <span class="dropdown-item">{{__('JPG')}}</span>
                                            </li>
                                            <li onclick="qrcodeDownload('{{$qrcode->img_data}}', 'svg')">
                                                <span class="dropdown-item">{{__('SVG')}}</span>
                                            </li>
                                            <li onclick="qrcodeDownload('{{$qrcode->img_data}}', 'png')">
                                                <span class="dropdown-item">{{__('PNG')}}</span>
                                            </li>
                                        </ul>        
                                    </div>

                                    <button 
                                        class="btn link-control" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteItem{{$qrcode->id}}"
                                    >
                                        <i class="fa-duotone fa-circle-trash text-danger"></i>
                                    </button>

                                    @include('components.DeletePopup', [
                                        'id' => $qrcode->id, 
                                        'action' => "/dashboard/delete-qrcode/".$qrcode->id
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 d-flex justify-content-center">
                    {{ $qrcodes->links() }}
                </div>
            </div>
        @else
            <div class="card py-4 px-3 shadow-sm border-0 text-center">
                <h5>{{__('No have any QR Codes')}}</h5>
            </div>
        @endif
    </div>
@endsection
