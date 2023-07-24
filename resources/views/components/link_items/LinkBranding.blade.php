<div class="my-3 accordion" id="branding">
   <div class="accordion-item">
       <h2 class="accordion-header" id="headingTwo">
           <button 
               type="button" 
               aria-expanded="true" 
               data-bs-toggle="collapse" 
               data-bs-target="#collapseTwo" 
               aria-controls="collapseTwo"
               class="accordion-button"
               style="padding-top: 12px; padding-bottom: 12px" 
           >
               {{__('Add Branding')}}
           </button>
       </h2>
       <div 
           id="collapseTwo" 
           aria-labelledby="headingTwo" 
           class="accordion-collapse collapse show" 
           data-bs-parent="#branding"
       >
         <div class="accordion-body bg-white">
            <div class="form-check form-switch">
               <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
               <label class="form-check-label" for="flexSwitchCheckDefault">
                  {{__('Display Branding')}}
               </label>
            </div>
         
            <div class="py-2">
               <label>{{__('Brand Name')}}</label>
               <input 
                  id="brandName" 
                  type="text" 
                  value="{{$link->branding}}"
                  data-linkId="{{$link->id}}"
                  class="form-control"       
               >
            </div>
         
            <div class="py-2">
               <label>{{__('Branding URL')}}</label>
               <input 
                  id="brandingUrl" 
                  type="text" 
                  value="{{$link->brand_url}}"
                  data-linkId="{{$link->id}}"
                  class="form-control"       
               >
            </div>
            <div class="py-2">
               <label>{{__('Text Color')}}</label>
               <input 
                  id="brandColor" 
                  type="color" 
                  value="{{$link->brand_color}}"
                  data-linkId="{{$link->id}}"
                  class="form-control color-input"       
               >
            </div>
         </div>
       </div>
   </div>
</div>

