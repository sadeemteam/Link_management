@extends('layouts.dashboard.dashboard')

@section('content')
    <div class="container py-3">
        <h4 class="mb-5" style="font-size: 24px">{{__('Project QRCodes')}}</h4>
        @if(count($project->qrcodes) > 0)
            <div class="row">
                @foreach($project->qrcodes as $qrcode)
                    <div class="col-lg-3 mb-5">
                        <div class="projectQRCode shadow-sm rounded">
                            <div class="qrCodeImage">
                                <div class="controlBox">
                                    <div class="downloadButton dropdown me-2">
                                        <button 
                                            class="btn btn-primary rounded-circle" 
                                            data-bs-toggle="dropdown" 
                                        >
                                            <i class="fa-solid fa-down-to-line"></i>
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

                                    <div class="deleteButton">
                                        <button 
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteItem{{$qrcode->id}}"
                                            class="btn btn-light rounded-circle link-control" 
                                        >
                                            <i class="fa-duotone fa-circle-trash text-danger"></i>
                                        </button>
                                    </div>
                                </div>

                                <img 
                                    width="100%" 
                                    src="{{$qrcode->img_data}}" 
                                    alt="qrCodeImage"
                                >
                            </div>                      
                        </div>
                    </div>
                    @include('components.DeletePopup', [
                        'id' => $qrcode->id, 
                        'action' => "/dashboard/delete-qrcode/".$qrcode->id
                    ])
                @endforeach
            </div>
        @else
            <div class="card py-4 px-3 shadow-sm border-0 text-center">
                <h5>{{__('No have any qrcodes')}}</h5>
            </div>
        @endif
    </div>
@endsection