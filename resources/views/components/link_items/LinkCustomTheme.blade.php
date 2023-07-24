<?php
   $buttonTypes = array(
      [
         'type'=>'rounded', 
         'color'=>'#000',
         'radius'=>'30px'
      ],
      [
         'type'=>'radius', 
         'color'=>'#000',
         'radius'=>'12px'
      ],
      [
         'type'=>'rectangle', 
         'color'=>'#000',
         'radius'=>'8px'
      ],
      [
         'type'=>'rounded-trans', 
         'color'=>'#fff',
         'radius'=>'30px'
      ],
      [
         'type'=>'radius-trans', 
         'color'=>'#fff',
         'radius'=>'12px'
      ],
      [
         'type'=>'rectangle-trans', 
         'color'=>'#fff',
         'radius'=>' 8px'
      ],
   );

   $fontFamily = [
      "Inter, sans-serif",
      "MintGrotesk, sans-serif",
      "DM Sans, sans-serif",
      "Bebas Neue, cursive",
      "Poppins, sans-serif",
      "Quicksand, sans-serif",
   ];

   $customTheme = $link->custom_theme_active;
?>

<div class="card p-4 mb-4 {{$customTheme ? 'd-block' : 'd-none'}}" id="customTheme">
   <h4>{{__('Custom Theme')}}</h4>
   <div class="row">
      <div class="col-6 col-lg-4 p-3">
         <div 
            style="height: 240px"
            class="customColorBox {{$customTheme ? $link->custom_theme->background_type == "color" ? 'activeItem' : '' : ''}}" 
         >
            <input 
               type="color" 
               id="customColorInput" 
               data-themeId="{{$customTheme ? $link->custom_theme_id : ''}}"
               class="form-control gradientBox p-0 h-100" 
            >
            <label for="customColorInput">
               <i class="fa-solid fa-eye-dropper-half"></i>
            </label>
         </div>
      </div>

      <div class="col-6 col-lg-4 p-3">
         <div 
            id="customImageBox" 
            style="height: 240px"
            class="customImageBox {{$customTheme ? $link->custom_theme->background_type == "image" ? 'activeItem' : '' : ''}}" 
         >
            <label for="customImage">
               <i class="fa-solid fa-camera"></i>
               <h6>{{__('Upload Photo')}}</h6>
            </label>
            <input 
               hidden
               type="file" 
               id="customImage" 
               data-theme="{{json_encode($link->custom_theme)}}"
               class="form-control" 
            >
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-4 my-3">
         <div class="buttonColorBox">
            <input 
               type="color" 
               id="themeTextColor" 
               value="{{$customTheme ? $link->custom_theme->text_color : ''}}"
               data-themeId="{{$customTheme ? $link->custom_theme_id : ''}}"
            >
            <label for="themeTextColor">
               <i class="fa-solid fa-eye-dropper-half"></i>
            </label>
         </div>
         <p class="text-center">{{__('Theme Text')}}</p>
      </div>
   </div>

   <div class="row mt-4">
      <h4>{{__('Button Type')}}</h4>
      @foreach($buttonTypes as $type)
         <div class="col-6 col-lg-4 my-3">
            <div 
               data-type="{{json_encode($type)}}"
               data-theme="{{json_encode($link->custom_theme)}}"
               class="buttonType linkButton {{$customTheme ? $link->custom_theme->btn_type == $type['type'] ? 'activeItem' : '' : ''}}"
               style="background: {{$type['color']}}; border-radius: {{$type['radius']}};" 
            ></div>
         </div>
      @endforeach

      <div class="col-4 my-3">
         <div class="buttonColorBox">
            <input 
               type="color" 
               id="btnBgColor" 
               value="{{$customTheme ? $link->custom_theme->btn_bg_color : ''}}"
               data-themeId="{{$customTheme ? $link->custom_theme_id : ''}}"
            >
            <label for="btnBgColor">
               <i class="fa-solid fa-eye-dropper-half"></i>
            </label>
         </div>
         <p class="text-center">{{__('Button Background')}}</p>
      </div>

      <div class="col-4 my-3">
         <div class="buttonColorBox">
            <input 
               type="color" 
               id="btnTextColor" 
               value="{{$customTheme ? $link->custom_theme->btn_text_color : ''}}"
               data-themeId="{{$customTheme ? $link->custom_theme_id : ''}}"
            >
            <label for="btnTextColor">
               <i class="fa-solid fa-eye-dropper-half"></i>
            </label>
         </div>
         <p class="text-center">{{__('Button Text')}}</p>
      </div>
   </div>

   <div class="row mt-4">
      <h4>{{__('Font Family')}}</h4>
      @foreach($fontFamily as $font)
         <div class="col-6 col-lg-4 my-3">
            <div 
               style="border-radius: 8px;" 
               data-font="{{json_encode($font)}}"
               data-theme="{{json_encode($link->custom_theme)}}"
               class="buttonType fontButton {{$customTheme ? $link->custom_theme->font_family == $font ? 'activeItem' : '' : ''}}"
            >
               <p style="font-family: {{$font}};" >{{$font}}</p>
            </div>
         </div>
      @endforeach
   </div>
</div>