<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Sript --}}
    <script src="{{ asset('js/fontawesome.js') }}" ></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <title>{{ $link->link_name }}</title>
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
    // $backgroundStyle = $link->theme->background;
    $backgroundStyle = $link->theme->bg_image ? "background-image: url('/{$link->theme->bg_image}');".$link->theme->background : $link->theme->background;
    $themeTextColor = $link->theme->text_color;
    $fontFamily = $link->theme->font_family;
}
?>

<style>
    #bioLink .textContent {
        color: {{ $themeTextColor }};
    }
</style>

<body style="font-family: {{ $fontFamily }} !important">
    <div id="bioLink" class="viewBioLink"
        style="
            min-height: 100vh;
            background-attachment: fixed;
            {{ $backgroundStyle }};
        ">
        <div class="container">
            <div class="row mx-auto py-3">
                <div class="col-lg-7 mx-auto">
                    <div class="linkProfile">
                        <img 
                        alt="" id="linkProfileImg"
                        src="{{ $link->thumbnail ? asset($link->thumbnail) : asset('assets/user-profile.png') }}"
                        >
                        <h5 class="mt-2 textContent">{{ $link->link_name }}</h5>
                        <p class="py-2 textContent">{{ $link->short_bio }}</p>
                        <div class="d-flex justify-content-center" style="flex-wrap: wrap">
                            @if ($link->socials)
                                <?php
                                $socials = json_decode($link->socials);
                                ?>
                                @foreach ($socials as $item)
                                    <?php
                                    $encode = json_encode($item);
                                    $Item = json_decode($encode, true);
                                    ?>
                                    @if ($Item['name'] == 'email')
                                        <a class="mx-2 fs-4" _target="_blank" href="mailto:{{ $Item['link'] }}">
                                            <i style="color: #1d2939" class="{{ $Item['icon'] }}"></i>
                                        </a>
                                    @elseif($Item['name'] == 'telephone')
                                        <a href="tel:{{ $Item['link'] }}" class="mx-2 fs-4">
                                            <i style="color: #1d2939" class="{{ $Item['icon'] }}"></i>
                                        </a>
                                    @elseif($Item['name'] == 'whatsapp')
                                        <a href="https://api.whatsapp.com/send?phone={{ $Item['link'] }}"
                                            target="_blank" class="mx-2 fs-4">
                                            <i style="color: #1d2939" class="{{ $Item['icon'] }}"></i>
                                        </a>
                                    @else
                                        <?php
                                        $linkUrl = explode('//', $Item['link'])[0];
                                        $validlLink;
                                        if ($linkUrl == 'https:' || $linkUrl == 'http:') {
                                            $validlLink = $Item['link'];
                                        } else {
                                            $validlLink = 'https://' . $linkUrl;
                                        }
                                        ?>
                                        <a class="mx-2 fs-4" target="_blank" href="{{ $validlLink }}">
                                            <i style="color: #1d2939" class="{{ $Item['icon'] }}"></i>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div>
                        @foreach ($link->items as $item)
                            <div class="text-center mb-3">
                                <?php
                                $type = $item->item_type;
                                $sub_type = $item->item_sub_type;
                                ?>

                                @if ($type == 'Image' || $type == 'Embed Link')
                                    <div id="mobileViewLinkItem" class="mobileViewLinkItem"
                                        style="{{ $buttonStyle }}">
                                        <div role="button" id="embedButton" aria-expanded="false"
                                            href="#embedLInkItem{{ $item->id }}" data-bs-toggle="collapse"
                                            onclick="embedButton({{ $item->id }})">
                                            <i class="textContent itemIcon {{ $item->item_icon }}"></i>
                                            <h6 class="textContent">
                                                {{ $item->item_title }}
                                            </h6>

                                            <i id="rightArrow{{ $item->id }}"
                                                class="textContent rightArrow fa-solid fa-angle-right"></i>
                                        </div>

                                        <div class="collapse" id="embedLInkItem{{ $item->id }}">
                                            <div class="pt-0" style="padding: 14px; background: transparent;">
                                                <div class="card border-0" style="overflow: hidden;">
                                                    @if ($sub_type == 'TikTok')
                                                        <?php
                                                        $str_arr = explode('/', $item->item_content);
                                                        $videoId = array_pop($str_arr);
                                                        ?>
                                                        <blockquote class="tiktok-embed"
                                                            cite="{{ $item->item_content }}"
                                                            data-video-id="{{ $videoId }}"
                                                            style="width: 100%; height: auto;">
                                                            <script async src="https://www.tiktok.com/embed.js"></script>
                                                        </blockquote>
                                                    @elseif($sub_type == 'Image')
                                                        <img width="100%" src="{{ asset($item->content) }}"
                                                            alt="">
                                                    @else
                                                        <iframe width="100%" height="400" frameborder="0"
                                                            allowfullscreen src="{{ $item->item_link }}"></iframe>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($type == 'Text Content')
                                    @if ($item->item_sub_type == 'paragraph')
                                        <div id="mobileViewLinkItem" class="mobileViewLinkItem"
                                            style="{{ $buttonStyle }}">
                                            <div role="button" id="embedButton" aria-expanded="false"
                                                data-bs-toggle="collapse" href="#embedLInkItem{{ $item->id }}"
                                                onclick="embedButton({{ $item->id }})">
                                                <i class="textContent itemIcon {{ $item->item_icon }}"></i>
                                                <h6 class="textContent">
                                                    {{ $item->item_title }}
                                                </h6>
                                                <i id="rightArrow{{ $item->id }}"
                                                    class="textContent rightArrow fa-solid fa-angle-right"></i>
                                            </div>

                                            <div class="collapse" id="embedLInkItem{{ $item->id }}">
                                                <div class="pt-0" style="padding: 14px; background: transparent;">
                                                    <div class="card border-0" style="overflow: hidden;">
                                                        <p>{{ $item->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <{{ $item->item_sub_type }} class="textContent">
                                            {{ $item->item_title }}
                                            </{{ $item->item_sub_type }}>
                                    @endif
                                @elseif($type == 'Link')
                                    <div id="mobileViewLinkItem" class="mobileViewLinkItem">
                                        <div style="padding: 14px; {{ $buttonStyle }}">
                                            <a target="_blank"
                                                class="d-flex justify-content-between align-items-center text-decoration-none"
                                                href="{{ $item->item_link }}">
                                                <i class="itemIcon textContent {{ $item->item_icon }}"></i>
                                                <h6 class="textContent">
                                                    {{ $item->item_title }}
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
        </div>

        <div>
            <img width="40px" style="border-radius: 6px" src="{{ asset($link->branding) }}" alt="">
        </div>
    </div>

    <script>
        function embedButton(id) {
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
