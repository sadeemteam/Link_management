<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('Document')}}</title>

    <link href="https://fonts.googleapis.com/css2?family=Radio+Canada:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<?php
    $customActive = $link->custom_theme_active;

    $buttonStyle = '';
    $backgroundStyle = '';
    $themeTextColor = '';
    $fontFamily = '';

    if ($customActive) {
        $buttonStyle = "
            background: {$link->custom_theme->btn_bg_color};
            border-radius: {$link->custom_theme->btn_radius};
        ";
        $backgroundStyle = $link->custom_theme->background;
        $themeTextColor = $link->custom_theme->text_color;
        $fontFamily = $link->custom_theme->font_family;
    } else {
        $buttonStyle = $link->theme->button_style;
        $backgroundStyle = $link->theme->bg_image ? "background-image: url('/{$link->theme->bg_image}');".$link->theme->background : $link->theme->background;
        $themeTextColor = $link->theme->text_color;
        $fontFamily = $link->theme->font_family;
    }
?>

<style>
    #bioLink .textContent{
        color: {{$themeTextColor}};
    }
    #bioLink .customThemeColor {
        color: {{$customActive ? $link->custom_theme->btn_text_color : $link->theme->text_color}};
    }
</style>

<body>
    <div
        id="bioLink"
        class="mobileViewLink"
        style="
            {{$backgroundStyle}};
            color: {{$themeTextColor}};
            font-family: {{$fontFamily}} !important;
        "
    >
        <div>
            <div class="linkProfileMobile">
                <img
                    alt=""
                    id="linkProfileImgMobile"
                    src="{{$link->thumbnail ? asset($link->thumbnail) : asset('assets/user-profile.png')}}"
                >
                <h5 class="mt-2 textContent">{{$link->link_name}}</h5>
                <p class="py-2 textContent">{{$link->short_bio}}</p>

                <div class="d-flex justify-content-center" style="flex-wrap: wrap" >
                    @if($link->socials)
                        <?php
                            $socials = json_decode($link->socials);
                        ?>
                        @foreach($socials as $item)
                            <?php
                                $encode = json_encode($item);
                                $Item = json_decode($encode, true);
                            ?>
                            @if($Item['name'] == 'email')
                                <a class="mx-2 fs-4" _target="_blank" href="mailto:{{$Item['link']}}">
                                    <i style="color: #1d2939" class="{{$Item['icon']}}"></i>
                                </a>

                            @elseif($Item['name'] == 'telephone')
                                <a href="tel:{{$Item['link']}}" class="mx-2 fs-4">
                                    <i style="color: #1d2939" class="{{$Item['icon']}}"></i>
                                </a>

                            @elseif($Item['name'] == 'whatsapp')
                                <a href="https://api.whatsapp.com/send?phone={{$Item['link']}}" target="_blank" class="mx-2 fs-4">
                                    <i style="color: #1d2939" class="{{$Item['icon']}}"></i>
                                </a>

                            @else
                                <?php
                                    $linkUrl = explode("//", $Item['link'])[0];
                                    $validlLink;
                                    if ($linkUrl == 'https:' || $linkUrl == 'http:') {
                                        $validlLink = $Item['link'];
                                    } else {
                                        $validlLink = 'https://'.$linkUrl;
                                    }
                                ?>
                                <a class="mx-2 fs-4" target="_blank" href="{{$validlLink}}">
                                    <i style="color: #1d2939" class="{{$Item['icon']}}"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <div>
                @foreach($link->items as $item)
                    <div class="text-center mb-3">
                    <?php
                        $type = $item->item_type;
                        $sub_type = $item->item_sub_type;
                    ?>

                    @if($type == 'Image' || $type == 'Embed Link')
                        <div class="mobileViewLinkItem" style="{{$buttonStyle}}">
                            <div
                                role="button"
                                id="embedButton"
                                aria-expanded="false"
                                data-bs-toggle="collapse"
                                href="#embedLInkItem{{$item->id}}"
                                onclick="embedButton({{$item->id}})"
                            >
                                <i class="customThemeColor itemIcon textContent {{$item->item_icon}}"></i>
                                <h6 class="customThemeColor textContent">
                                    {{$item->item_title}}
                                </h6>

                                <i
                                    id="rightArrow{{$item->id}}"
                                    class="customThemeColor itemIcon textContent rightArrow fa-solid fa-angle-right"
                                ></i>
                            </div>

                            <div class="collapse" id="embedLInkItem{{$item->id}}">
                                <div class="pt-0" style="padding: 14px; background: transparent;">
                                    <div class="card" style="overflow: hidden;">
                                        @if($sub_type == "TikTok")
                                            <?php
                                                $str_arr = explode ("/", $item->item_content);
                                                $videoId = array_pop($str_arr);
                                            ?>
                                            <blockquote
                                                class="tiktok-embed"
                                                cite="{{$item->item_content}}"
                                                data-video-id="{{$videoId}}"
                                                style="width: 100%; height: auto;"
                                            >
                                                <script async src="https://www.tiktok.com/embed.js"></script>
                                            </blockquote>

                                        @elseif($sub_type == "Image")
                                            <img width="100%" src="{{asset($item->content)}}" alt="">

                                        @else
                                            <iframe
                                                width="100%"
                                                height="200"
                                                frameborder="0"
                                                allowfullscreen
                                                src="{{$item->item_link}}"
                                            ></iframe>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif($type == 'Text Content')
                        @if($item->item_sub_type == 'paragraph')
                            <div class="mobileViewLinkItem" style="{{$buttonStyle}}">
                                <div
                                    role="button"
                                    id="embedButton"
                                    aria-expanded="false"
                                    data-bs-toggle="collapse"
                                    href="#embedLInkItem{{$item->id}}"
                                    onclick="embedButton({{$item->id}})"
                                >
                                    <i class="textContent itemIcon {{$item->item_icon}}"></i>
                                    <h6 class="textContent">
                                        {{$item->item_title}}
                                    </h6>
                                    <i id="rightArrow{{$item->id}}" class="textContent rightArrow fa-solid fa-angle-right"
                                    ></i>
                                </div>

                                <div
                                    class="collapse"
                                    id="embedLInkItem{{$item->id}}"
                                >
                                    <div class="pt-0" style="padding: 14px; background: transparent;">
                                        <div class="card border-0" style="overflow: hidden;">
                                            <p>{{$item->content}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <{{$item->item_sub_type}} class="textContent">
                                {{$item->item_title}}
                            </{{$item->item_sub_type}}>
                        @endif

                    @elseif($type == 'Link')
                        <div class="mobileViewLinkItem" style="{{$buttonStyle}}">
                            <div class="linkItemContent" style="padding: 14px;">
                                <a
                                    target="_blank"
                                    class="d-flex justify-content-between align-items-center text-decoration-none"
                                    href="/{{$item->item_link}}"
                                >
                                    <i class="customThemeColor itemIcon textContent {{$item->item_icon}}"></i>
                                    <h6 class="customThemeColor textContent">
                                        {{$item->item_title}}
                                    </h6>
                                    <div style="width: 24px"></div>
                                </a>
                            </div>
                        </div>
                    @endif
                    </div>
                @endforeach
            </div>
        </div>


    </div>

    <script>
        function embedButton (id) {
            let rightArrow = document.getElementById(`rightArrow${id}`).classList;
            if (rightArrow.contains("active")) {
                rightArrow.add("inactive");
                rightArrow.remove("active");
            } else {
                rightArrow.add("active");
                rightArrow.remove("inactive");
            }
        }
    </script>
</body>
</html>
