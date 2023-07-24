<div class="modal fade" id="modal{{$item->id}}" aria-hidden="true" aria-labelledby="updateLinkItemsModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLinkItemsModalLabel">
                    {{__('Update Link Item')}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="showUpdateError{{$item->id}}" class="alert alert-danger d-none py-2">
                    {{__('hello')}}
                </div>
                <form name="linkItemUpdate{{$item->id}}">
                    <input hidden id="itemInfo{{$item->id}}" value="{{json_encode($item)}}" >
                    @switch($item->item_type)
                        @case('Link')
                            <div class="mb-3">
                                <label>{{__('Name')}}</label>
                                <input 
                                    required
                                    type="text" 
                                    id="updateLinkText" 
                                    value="{{$item->item_title}}" 
                                    class="form-control"
                                >
                            </div>
                            <div class="mb-3">
                                <label>{{__('Destination URL')}}</label>
                                <input 
                                    required
                                    type="text" 
                                    id="updateLinkUrl" 
                                    class="form-control"
                                    value="{{$item->content}}"
                                    placeholder="Example:https://ui-lib.com/" 
                                >
                            </div>
                            @break

                        @case('Text Content')
                            @if($item->item_sub_type == 'paragraph')
                                <div class="mb-3">
                                    <label>{{__('Title')}}</label>
                                    <input 
                                        required
                                        type="text" 
                                        value="{{$item->item_title}}" 
                                        id="updateParagraphTitle" 
                                        class="form-control"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label>{{__('Description')}}</label>
                                    <textarea 
                                        rows="6" 
                                        required
                                        class="form-control"
                                        id="updateParagraphText" 
                                    >{{$item->content}}</textarea>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label>
                                        {{__('Heading Type')}} {{$item->item_sub_type}}
                                    </label>
                                    <select 
                                        id="updateHeadingType"
                                        class="form-select" 
                                    >
                                        <option 
                                            selected 
                                            value="{{$item->item_sub_type}}"
                                        >
                                            {{strtoupper($item->item_sub_type)}}
                                        </option>
                                        <option value="h1">{{__('H1')}}</option>
                                        <option value="h2">{{__('H2')}}</option>
                                        <option value="h3">{{__('H3')}}</option>
                                        <option value="h4">{{__('H4')}}</option>
                                        <option value="h5">{{__('H5')}}</option>
                                        <option value="h6">{{__('H6')}}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>{{__('Text')}}</label>
                                    <input 
                                        required
                                        type="text" 
                                        id="updateHeadingText" 
                                        value="{{$item->item_title}}" 
                                        class="form-control"
                                    >
                                </div>
                            @endif
                            @break

                        @case('Image')
                            <div class="mb-3">
                                <img width="100px" src="{{asset($item->content)}}" alt="">
                                <input id="currentImage" value="{{$item->content}}" hidden>

                                <label style="display: block; margin-top: 12px">
                                    {{__('Image')}}
                                </label>
                                <input type="file" id="updateImageFile" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>{{__('Image Title')}}</label>
                                <input required type="text" value="{{$item->item_title}}" id="updateImageAlt" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>{{__('Destination URL (Optional)')}}</label>
                                <input type="text" value="{{$item->item_link}}" id="updateImageUrl" class="form-control">
                            </div>
                            @break

                        @case("Embed Link")
                            <div class="mb-3">
                                <label class="mb-2">
                                    {{$item->item_title}} {{__('Video URL')}}
                                </label>
                                <input 
                                    required
                                    type="text" 
                                    id="update{{$item->item_title}}Url" 
                                    value="{{$item->item_link}}" 
                                    class="form-control"
                                >
                            </div>
                            @break
                    
                        @default
                            <h1>{{__('Empty')}}</h1>
                    @endswitch

                    <button 
                        type="submit"
                        class="form-control btn btn-primary mt-3"
                    >
                        {{__('Submit')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.forms["linkItemUpdate{{$item->id}}"].onsubmit = function (e) {
        e.preventDefault();
        const item = JSON.parse(document.getElementById('itemInfo{{$item->id}}').value);

        async function appendElement(updatedItem) {
            const res = await axios.put(`/dashboard/biolink/edit-item/${item.id}`, updatedItem);

            if (res.data.error) {
                window.showMessage("showUpdateError{{$item->id}}", res.data.error, 2000);
            } else {
                window.location.reload();
            }
        }

        async function embedLinkUpdate(name, link) {
            appendElement({
                item_type: "Embed Link",
                item_sub_type: name,
                item_title: name,
                item_link: link,
                content: null,
            });
        }

        async function singleImageUpload(imgInputId, prevImg) {
            const file = window.idSelector(imgInputId).files[0];
            let fileData = new FormData();
            fileData.append("image", file);
            const result = await axios.post(
                `/file-upload/${prevImg.split("/")[1]}`,
                fileData,
                { headers: { "content-type": "multipart/form-data" } }
            );
            return result.data;
        }

        switch (item.item_sub_type) {
            case "Link":
                (() => {
                    const title = window.idSelector("updateLinkText").value;
                    const link = window.idSelector("updateLinkUrl").value;

                    appendElement({
                        item_type: "Link",
                        item_sub_type: "Link",
                        item_title: title,
                        item_link: link,
                        content: null,
                    });
                })();
                break;

            case "paragraph":
                (() => {
                    const content = window.idSelector("updateParagraphText").value;
                    const title = window.idSelector("updateParagraphTitle").value;

                    appendElement({
                        item_type: "Text Content",
                        item_sub_type: "paragraph",
                        item_title: title,
                        item_link: null,
                        content,
                    });
                })();
                break;

            case "Image":
                (async () => {
                    const newImg = window.idSelector("updateImageFile").value;
                    const prevImg = window.idSelector("currentImage").value;

                    let imgUrl;
                    if (newImg) {
                        imgUrl = await singleImageUpload(
                            "updateImageFile",
                            prevImg
                        );
                    } else {
                        imgUrl = prevImg;
                    }
                    const title = window.idSelector("updateImageAlt").value;
                    const link = window.idSelector("updateImageUrl").value;

                    appendElement({
                        item_type: "Image",
                        item_sub_type: "Image",
                        item_title: title,
                        item_link: link,
                        content: imgUrl,
                    });
                })();
                break;

            case "SoundCloud":
                (() => {
                    const link = window.idSelector(`updateSoundCloudUrl`).value;
                    const embedUrl = `https://w.soundcloud.com/player/?url=${link}&amp;color=%23ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;show_teaser=true&amp;visual=true`;
                    embedLinkUpdate("SoundCloud", embedUrl);
                })();
                break;

            case "YouTube":
                (() => {
                    const url = window.idSelector(`updateYouTubeUrl`).value;
                    const lastUrl = url.split("/").pop();
                    const videoId = lastUrl.split("=").pop();
                    const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                    embedLinkUpdate("YouTube", embedUrl);
                })();
                break;

            case "Spotify":
                (() => {
                    const url = idSelector2(`updateSpotifyUrl`).value;
                    let urlArray = url.split("/");
                    const videoId = urlArray.pop();
                    const videoType = urlArray.pop();
                    const videoUrl = `${videoType}/${videoId.split("?")[0]}`;
                    const embedUrl = `https://open.spotify.com/embed/${videoUrl}`;
                    embedLinkUpdate("Spotify", embedUrl);
                })();
                break;

            case "Vimeo":
                (() => {
                    const url = window.idSelector(`updateVimeoUrl`).value;
                    const lastUrl = url.split("/").pop();
                    const embedUrl = `https://player.vimeo.com/video/${lastUrl}`;
                    embedLinkUpdate("Vimeo", embedUrl);
                })();
                break;

            case "TikTok":
                (() => {
                    const link = window.idSelector(`updateTiktokUrl`).value;
                    embedLinkUpdate("YouTube", link);
                })();
                break;

            default:
                (() => {
                    const sub_type = window.idSelector("updateHeadingType").value;
                    const title = window.idSelector("updateHeadingText").value;

                    appendElement({
                        item_type: "Text Content",
                        item_sub_type: sub_type,
                        item_title: title,
                        item_link: null,
                        content: null,
                    });
                })();
        }
    };

</script>