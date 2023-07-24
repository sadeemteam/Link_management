<div class="card mb-4 order-summery">
   <div class="summery-header bg-light" >
       <h6>{{__('Order Summery')}}</h6>
   </div> 
   <div class="border-top"></div>

   <div class="summery-body">
       <div class="body-item">
           <p class="title">{{__('Plan')}}</p>
           <p>{{$plan->name}}</p>
       </div>
   </div>

   <div class="summery-body">
       <div class="body-item">
           <p class="title">{{__('Billing Type')}}</p>
           <p id="frequency">
                {{$type == 'monthly' ? 'Monthly' : 'Yearly'}} 
            </p>
       </div>
   </div>

   <div class="summery-body">
       <div class="body-item">
           <p class="title">{{__('Pay With')}}</p>
           <p id="paymentMethod">{{__('Stripe')}}</p>
       </div>
   </div>

   <div class="summery-body">
       <div class="body-item">
           <p class="title">{{__('Price')}}</p>
           <p id="summeryPrice">
                {{$type == 'monthly' ? $plan->monthly_price : $plan->yearly_price}} 
                {{__('USD')}}
                {{$plan->currency}}
            </p>
       </div>
   </div>

   <div class="border-top"></div>
   <div class="summery-footer bg-light" >
       <h6>{{__('Total')}}</h6>
       <h6 id="totalPrice">
            {{$type == 'monthly' ? $plan->monthly_price : $plan->yearly_price}} 
            {{__('USD')}}
        </h6>
   </div> 
</div>