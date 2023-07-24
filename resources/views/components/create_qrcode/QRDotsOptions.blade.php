<div class="accordion-body bg-white">
   <div class="py-2">
      <label>{{__('Dots Style')}}</label>
      <select 
         id="dotStyle"
         class="form-select" 
         aria-label="Default select example" 
      >
         <option value="rounded" selected>{{__('Rounded')}}</option>
         <option value="dots" >{{__('Dots')}}</option>
         <option value="classy">{{__('Classy')}}</option>
         <option value="classy-rounded">{{__('Classy Rounded')}}</option>
         <option value="square">{{__('Square')}}</option>
         <option value="extra-rounded">{{__('Extra Rounded')}}</option>
      </select>
   </div>

   <div class="py-2">
      <label>{{__('Dots Color')}}</label>
      <input 
         id="dotColor" 
         type="color" 
         value="300"
         class="form-control" 
      >
   </div>

   <div class="py-2">
      <label>{{__('Background Color')}}</label>
      <input 
         id="dotBackground" 
         type="color" 
         value="300"
         class="form-control" 
      >
   </div>
</div>