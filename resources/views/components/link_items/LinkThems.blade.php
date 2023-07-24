<?php
    $SA = $user->hasRole('SUPER-ADMIN');

    function themeAccess($plan, $theme, $SA)
    {
        if ($SA) {
            return true;
        }
        if ($plan->themes == 'Free') {
            if ($theme->type == 'Free') {
                return true;
            } else {
                return false;
            }
        } else if ($plan->themes == 'Standard') {
            if ($theme->type == 'Free' || $theme->type == 'Standard') {
                return true;
            } else {
                return false;
            }
        } else if ($plan->themes == 'Premium') {
            return true;
        } else {
            return false;
        }
    }
?>

{{-- {{dd($plan->name)}} --}}
<div class="card p-4 mb-4 themes">
    <h4 class="mb-2">{{__('Themes')}}</h4>
    <div class="row">
        @foreach($themes as $theme)
            <div class="col-6 col-lg-4 p-3">
                <div 
                    style="{{$theme->bg_image ? "background-image: url('/{$theme->bg_image}');".$theme->background : $theme->background}}"
                    data-link="{{json_encode($link)}}"
                    data-theme="{{json_encode($theme)}}"
                    class="themeCard {{$link->theme_id == $theme->id ? 'active' : ''}} {{themeAccess($plan, $theme, $SA) ? 'free' : 'pro'}}" 
                >
                    @for ($i=0; $i<4 ; $i++)
                        <div class="contentButton" style="{{$theme->button_style}}"></div>
                    @endfor

                    <div id="{{themeAccess($plan, $theme, $SA) ? 'freeTheme' : 'proTheme'}}">
                        <span>{{themeAccess($plan, $theme, $SA) ? '' : $theme->type}}</span>
                    </div>
                </div>
                <h6 class="text-center mt-2">
                    {{$theme->name}}
                </h6>
            </div>
        @endforeach

        <div class="col-6 col-lg-4 p-3">
            <div 
                onclick="createCustomTheme({{$link}})"
                class="themeCard {{$link->custom_theme_active ? 'active' : ''}} {{$SA || $plan->custom_theme ? 'free' : 'pro'}}" 
            >
                <span>{{__('Create Theme')}}</span>

                <div id="{{$SA || $plan->custom_theme ? 'freeTheme' : 'proTheme'}}">
                    <span>{{$SA || $plan->custom_theme ? '' : 'Not Access'}}</span>
                </div>
            </div>
            <h6 class="text-center mt-2">
                {{__('Create Theme')}}
            </h6>
        </div>

        <div class="col-6 col-lg-4 p-3">
            <div class="bioLinkLogoBox {{!$SA && $plan->name == 'BASIC' ? 'pro' : 'free'}}">
                <img 
                    alt=""
                    id="bioLinkLogo" 
                    src="{{asset($link->branding)}}" 
                >
                <label class="bioLinkLogoUploader" for="bioLinkLogoInput">
                    <i class="fa-solid fa-camera"></i>
                </label>
                <input hidden id="prevLogo" value="{{$link->branding}}" >
                <input 
                    hidden 
                    type="file" 
                    name="bioLinkLogo"
                    id="bioLinkLogoInput"
                    data-themeid="{{$link->id}}"
                >

                <div id="{{!$SA && $plan->name == 'BASIC' ? 'proTheme' : 'freeTheme'}}">
                    <span>{{!$SA && $plan->name == 'BASIC' ? 'Standard/Premium' : ''}}</span>
                </div>
            </div>
            <h6 class="text-center mt-2">
                {{__('Manage Logo')}}
            </h6>
        </div>
    </div>
</div>