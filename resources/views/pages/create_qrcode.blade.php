@extends('layouts.dashboard.dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <h5 style="font-size: 22px">{{__('QR Code')}}</h5>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card p-3">
                    <form name="qrCodeCreateForm" >
                        <div class="mainInputArea">
                            @include('components.create_qrcode.QRCodeInputFields')
                        </div>

                        <div class="my-3 accordion accordion-flush" id="QRAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button 
                                        type="button" 
                                        aria-expanded="true" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapseOne" 
                                        aria-controls="collapseOne"
                                        class="accordion-button"
                                        style="padding-top: 12px; padding-bottom: 12px" 
                                    >
                                        {{__('Main Options')}}
                                    </button>
                                </h2>
                                <div 
                                    id="collapseOne" 
                                    aria-labelledby="headingOne" 
                                    class="accordion-collapse collapse show" 
                                    data-bs-parent="#QRAccordion"
                                >
                                    @include('components.create_qrcode.QRMainOptions')
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button 
                                        type="button" 
                                        aria-expanded="false" 
                                        data-bs-toggle="collapse" 
                                        aria-controls="collapseTwo"
                                        data-bs-target="#collapseTwo" 
                                        class="accordion-button collapsed"
                                        style="padding-top: 12px; padding-bottom: 12px" 
                                    >
                                        {{__('Dots Options')}}
                                    </button>
                                </h2>
                                <div 
                                    id="collapseTwo" 
                                    aria-labelledby="headingTwo" 
                                    class="accordion-collapse collapse" 
                                    data-bs-parent="#QRAccordion"
                                >
                                    @include('components.create_qrcode.QRDotsOptions')
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button 
                                        type="button" 
                                        aria-expanded="false" 
                                        data-bs-toggle="collapse" 
                                        aria-controls="collapseThree"
                                        data-bs-target="#collapseThree" 
                                        class="accordion-button collapsed"
                                        style="padding-top: 12px; padding-bottom: 12px" 
                                    >
                                        {{__('Corner Square Option')}}
                                    </button>
                                </h2>
                                <div 
                                    id="collapseThree" 
                                    aria-labelledby="headingThree" 
                                    class="accordion-collapse collapse" 
                                    data-bs-parent="#QRAccordion"
                                >
                                    @include('components.create_qrcode.QRCornerSquareOptions')
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button 
                                        type="button" 
                                        aria-expanded="false" 
                                        data-bs-toggle="collapse" 
                                        aria-controls="collapseFour"
                                        data-bs-target="#collapseFour" 
                                        class="accordion-button collapsed"
                                        style="padding-top: 12px; padding-bottom: 12px" 
                                    >
                                        {{__('Logo Option')}}
                                    </button>
                                </h2>
                                <div 
                                    id="collapseFour" 
                                    aria-labelledby="headingFour" 
                                    class="accordion-collapse collapse" 
                                    data-bs-parent="#QRAccordion"
                                >
                                    @include('components.create_qrcode.QRImageOptions')
                                </div>
                            </div>
                        </div>

                        <button 
                            type="submit"
                            class="form-control btn btn-primary text-white"
                        >
                            {{__('Create & Save')}}
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div id="canvas"></div>
                <div class="downloadBox" id="downloadBox">
                    <button 
                        onclick="downloadQR()"
                        class="btn btn-primary text-white form-control" 
                    >
                        {{__('Download')}}
                    </button>
                    <select class="downloadType form-select ms-3">
                        <option value="jpg" selected>{{__('JPG')}}</option>
                        <option value="svg">{{__('SVG')}}</option>
                        <option value="png">{{__('PNG')}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection
