@php
   foreach($socialLinks as $social){
      $social->link = NULL;
   }
   if($link->socials) {
      $socials = json_decode($link->socials);
      foreach($socials as $item){
         $encode = json_encode($item);
         $Item = json_decode($encode, true);

         foreach($socialLinks as $social){
            if ($Item["name"] == strtolower($social["name"])) {
               $social->link = $Item['link'];
               break;
            }
         }
      }
   }  
@endphp

<div class="card mb-4 p-4">
   <div class="d-flex align-items-center justify-content-center" style="flex-wrap: wrap" >
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
               <a class="mx-2 fs-3" _target="_blank" href="mailto:{{$Item['link']}}">
                  <i style="color: #1d2939" class="{{$Item['icon']}}"></i>
               </a>

            @elseif($Item['name'] == 'telephone')
               <a href="tel:{{$Item['link']}}" class="mx-2 fs-3">
                  <i style="color: #1d2939" class="{{$Item['icon']}}"></i>
               </a>

            @elseif($Item['name'] == 'whatsapp')
               <a href="https://api.whatsapp.com/send?phone={{$Item['link']}}" target="_blank" class="mx-2 fs-3">
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
               <a class="mx-2 fs-3" target="_blank" href="{{$validlLink}}">
                  <i style="color: #1d2939" class="{{$Item['icon']}}"></i>
               </a>
            @endif
         @endforeach
      @else 
         <h4>{{__('Socials Links')}}</h4>
      @endif

      <button 
         type="button" 
         style="padding: 6px; height: 34px; width: 34px;"
         class="ms-2 btn btn-outline-primary rounded-circle shadow-sm"
         data-bs-toggle="modal" 
         data-bs-target="#exampleModal"
      >
         <i style="font-size: 20px" class="fa-regular fa-plus"></i>
      </button>
   </div>
</div>
 
 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
      <div class="modal-content p-2">
         <div class="modal-header border-0">
            <h5 class="modal-title">{{__('Social Links')}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         
         <div class="modal-body">
            <form name="socialLinksForm">
               @csrf

               @foreach($socialLinks as $social)
                  <div class="mb-3">
                     <div class="input-group mb-3">
                        <span class="input-group-text" id="prefix" style="width: 44px" >
                           <i class="{{$social['icon']}}"></i>
                        </span>
                        <input 
                           type="text" 
                           id="{{$social['linkType']}}Input" 
                           class="form-control px-2 border-start-0" 
                           placeholder="{{$social['placeholder']}}"
                           value="{{$social['link']}}"
                        >
                     </div>
                  </div>
               @endforeach

               <button 
                  type="submit" 
                  onclick="submitSocials({{$link->id}})"
                  class="mt-3 text-white form-control btn btn-primary"
               >
                  {{__('Create')}}
               </button>
            </form>
         </div>
      </div>
   </div>
 </div>