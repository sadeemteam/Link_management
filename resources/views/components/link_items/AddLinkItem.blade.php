<?php
    $user = auth()->user();
    $position = $itemLastPosition;
    $basicPlan = $user->hasRole('BASIC');
    $superAdmin = $user->hasRole('SUPER-ADMIN');

    $blockItems = array(
        array('title'=>'Link', 'type'=>'linkItem', 'badge'=>'Pro'),
        array('title'=>'Heading', 'type'=>'headingItem', 'badge'=>'Pro'),
        array('title'=>'Paragraph', 'type'=>'paragraphItem', 'badge'=>'Pro'),
        array('title'=>'Image', 'type'=>'imageItem', 'badge'=>'Pro'),
        array('title'=>'SoundCloud', 'type'=>'soundCloudItem', 'badge'=>'Pro'),
        array('title'=>'YouTube', 'type'=>'youTubeItem', 'badge'=>'Pro'),
        array('title'=>'Spotify', 'type'=>'spotifyItem', 'badge'=>'Pro'),
        array('title'=>'Vimeo', 'type'=>'vimeoItem', 'badge'=>'Pro'),
        array('title'=>'TikTok', 'type'=>'tiktokItem', 'badge'=>'Pro'),
    );

    if ($superAdmin) {
        foreach ($blockItems as $key => $value) {
            $blockItems[$key]['badge'] = NULL;
        }
    }else{
        for ($i=0; $i<count($blockItems); $i++) { 
            if ($plan->biolink_blocks > $i) {
                $blockItems[$i]['badge'] = NULL;
            }             
        }
    }
?>

<div class="modal fade" id="addLinkItemsModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLinkItemsModalLabel">{{__('Add a new block')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body py-4">
                @foreach($blockItems as $item)
                    @if($basicPlan)
                        @if($item['badge'] == 'Pro')
                            <button 
                                data-bs-toggle="modal" 
                                data-bs-target="#addLinkItemsModal2"
                                class="linkItem my-2 btn btn-light" 
                                onclick="selectedLinkItem('{{$item['type']}}', {{$position}})"
                                disabled
                            >
                                <span class="badge">{{$item['badge']}}</span>
                                <h5 class="m-0 text-center">{{$item['title']}}</h5>
                            </button>
                        @else
                            <button 
                                data-bs-toggle="modal" 
                                data-bs-target="#addLinkItemsModal2"
                                class="linkItem my-2 btn btn-light" 
                                onclick="selectedLinkItem('{{$item['type']}}', {{$position}})"
                            >
                                <h5 class="m-0 text-center">{{$item['title']}}</h5>
                            </button>
                        @endif
                    @else
                        <button 
                            data-bs-toggle="modal" 
                            data-bs-target="#addLinkItemsModal2"
                            class="linkItem my-2 btn btn-light" 
                            onclick="selectedLinkItem('{{$item['type']}}', {{$position}})"
                        >
                            <h5 class="m-0 text-center">{{$item['title']}}</h5>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addLinkItemsModal2">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <button class="btn" data-bs-target="#addLinkItemsModal" data-bs-toggle="modal">
                        <i class="fa-solid fa-angles-left"></i>
                    </button>
                    <h5 class="modal-title" id="linkItemsTitle"></h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="showError" class="alert alert-danger d-none py-2"></div>
                {{-- Link type block --}}
                <div id="linkItem" style="display: none">
                    <form name="linkItem">
                        <div class="mb-3">
                            <label>{{__('Name')}}</label>
                            <input required type="text" id="linkText" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>{{__('Destination URL')}}</label>
                            <input required type="text" id="linkUrl" placeholder="Example:https://ui-lib.com/" class="form-control">
                        </div>

                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            
                {{-- Heading type block --}}
                <div id="headingItem" style="display: none">
                    <form name="headingItem">
                        <div class="mb-3">
                            <label>{{__('Heading Type')}}</label>
                            <select id="headingType" class="form-select">
                                <option selected value="h1" >{{__('H1')}}</option>
                                <option value="h2">{{__('H2')}}</option>
                                <option value="h3">{{__('H3')}}</option>
                                <option value="h4">{{__('H4')}}</option>
                                <option value="h5">{{__('H5')}}</option>
                                <option value="h6">{{__('H6')}}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>{{__('Heading Text')}}</label>
                            <input required type="text" id="headingText" class="form-control">
                        </div>
                        
                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            
                {{-- Paragraph type block --}}
                <div id="paragraphItem" style="display: none">
                    <form name="paragraphItem">
                        <div class="mb-3">
                            <label>{{__('Title')}}</label>
                            <input required type="text" id="paragraphTitle" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>{{__('Description')}}</label>
                            <textarea required id="paragraphText" rows="6" class="form-control"></textarea>
                        </div>
                        
                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            
                {{-- Image type block --}}
                <div id="imageItem" style="display: none">
                    <form name="imageItem">
                        <div class="mb-3">
                            <label>{{__('Image')}}</label>
                            <input required type="file" id="imageFile" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>{{__('Image Title')}}</label>
                            <input required type="text" id="imageAlt" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>{{__('Destination URL (Optional)')}}</label>
                            <input type="text" id="imageUrl" class="form-control">
                        </div>
                        
                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            
                {{-- SoundCloud Link block --}}
                <div id="soundCloudItem" style="display: none">
                    <form name="soundCloudItem">
                        <small>
                            {{__('Paste in your Soundcloud URL and we will show it as a playable song on your profile.')}}
                        </small>
                        <div class="mb-3">
                            <label>{{__('Soundcloud URL')}}</label>
                            <input required type="text" id="soundCloudUrl" class="form-control">
                        </div>
                        
                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            
                {{-- YouTube Link block --}}
                <div id="youTubeItem" style="display: none">
                    <form name="youTubeItem">
                        <small>
                            {{__('Paste in your YouTube video URL and we will show it as a video on your profile.')}}
                        </small>
                        <div class="mb-3">
                            <label>{{__('YouTube Video URL')}}</label>
                            <input required type="text" id="youTubeUrl" class="form-control">
                        </div>
                        
                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            
                {{-- Spotify Link block --}}
                <div id="spotifyItem" style="display: none">
                    <form name="spotifyItem">
                        <small>
                            {{__('Paste in your Spotify Song, Album, Show or Episode URL and we will show it as a player on your profile.')}}
                        </small>
                        <div class="mb-3">
                            <label>{{__('Spotify URL')}}</label>
                            <input required type="text" id="spotifyUrl" class="form-control">
                        </div>
                        
                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            
                {{-- Vimeo Link block --}}
                <div id="vimeoItem" style="display: none">
                    <form name="vimeoItem">
                        <small>
                            {{__('Paste in your Vimeo URL and we will show it as a video on your profile.')}}
                        </small>
                        <div class="mb-3">
                            <label>{{__('Vimeo URL')}}</label>
                            <input required type="text" id="vimeoUrl" class="form-control">
                        </div>
                        
                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            
                {{-- TikTok Link block --}}
                <div id="tiktokItem" style="display: none">
                    <form name="tiktokItem">
                        <small>
                            {{__('Paste in your TikTok Video URL and we will show it as a video on your profile.')}}
                        </small>
                        <div class="mb-3">
                            <label>{{__('TikTok Video URL')}}</label>
                            <input required type="text" id="tiktokUrl" class="form-control">
                        </div>
                        
                        <button type="submit" class="form-control text-white btn btn-primary mt-3">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>