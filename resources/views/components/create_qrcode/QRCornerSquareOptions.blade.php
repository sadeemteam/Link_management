<div class="accordion-body bg-white">
   <div class="py-2">
      <label>{{__('Corners Square Style')}}</label>
      <select 
         id="cornerType"
         class="form-select"         
      >
         <option selected value="dot" >{{__('Dots')}}</option>
         <option value="square">{{__('Square')}}</option>
         <option value="extra-rounded">{{__('Extra Rounded')}}</option>
      </select>
   </div>
   <div class="py-2">
      <label>{{__('Corners Square Color')}}</label>
      <input 
         id="cornerColor" 
         type="color" 
         value="300"
         class="form-control" 
      >
   </div>
</div>