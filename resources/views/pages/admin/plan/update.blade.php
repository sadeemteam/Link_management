@extends('layouts.dashboard.dashboard')

@section('content')
   <div class="container mt-3 mb-4">
      <h4 class="mb-5" style="font-size: 24px">{{__('Create New Pricing Plan')}}</h4>
      
      <div class="row">
         <div class="col-lg-10 mx-auto">
            <form 
                class="card p-4" 
                method="POST" 
                action="{{route('plan.update', $plan->id)}}"
            >
               @csrf
               @method('PUT')

               <div class="row">
                  <h5 class="mb-4">{{__('Pyement Info')}}</h5>
                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Plan Name')}}</label>
                     <select 
                        required
                        name="name" 
                        class="form-control px-2"
                     >
                        <option value="BASIC" @if($plan->name == 'BASIC') selected @endif>
                            {{__('BASIC')}}
                        </option>
                        <option value="STANDARD" @if($plan->name == 'STANDARD') selected @endif>
                            {{__('STANDARD')}}
                        </option>
                        <option value="PREMIUM" @if($plan->name == 'PREMIUM') selected @endif>
                            {{__('PREMIUM')}}
                        </option>
                     </select>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Description')}}</label>
                     <input 
                        required 
                        name="description"
                        value="{{$plan->description}}"
                        placeholder="Lenght will be 1 to 60 characters"
                        class="form-control px-2" 
                     >
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Monthly Price')}}</label>
                     <input 
                        required
                        type="number" 
                        name="monthly_price"
                        value="{{$plan->monthly_price}}"
                        placeholder="Monthly plan price"
                        class="form-control px-2" 
                     >
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Yearly Price')}}</label>
                     <input 
                        required
                        type="number" 
                        name="yearly_price"
                        value="{{$plan->yearly_price}}"
                        placeholder="Yearly plan price"
                        class="form-control px-2" 
                     >
                  </div>
   
                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Currency')}}</label>
                     <select 
                        required 
                        id="currency" 
                        name="currency" 
                        data-default="{{$plan->currency}}"
                        class="form-control px-2" 
                     ></select>

                     <script src="{{asset('js/currencies.js')}}"></script>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Plan Status')}}</label>
                     <select 
                        required
                        name="status" 
                        class="form-control px-2"
                     >
                        <option value="active" @if($plan->status == 'active') selected @endif>
                            {{__('Active')}}
                        </option>
                        <option value="deactive" @if($plan->status == 'deactive') selected @endif>
                            {{__('Deactive')}}
                        </option>
                     </select>
                  </div>

                  {{-- Plan features from here --}}
                  <h5 class="my-4">{{__('Features Info')}}</h5>
                  <div class="col-12 col-md-6 mb-3">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">{{__('Biolink Create')}}</label>
                        <div class="form-check reverse">
                           <input 
                              id="biolink"
                              type="checkbox" 
                              class="form-check-input" 
                              @if($plan->biolinks == 'Unlimited') checked @endif
                           >
                           <label class="form-check-label" for="biolink">
                              {{__('Unlimited')}}
                           </label>
                        </div>
                     </div>
                     <input 
                        required
                        id="biolinks"
                        type="number" 
                        name="biolinks"
                        value="{{$plan->biolinks}}"
                        placeholder="How many biolinks can create"
                        class="form-control px-2" 
                     >
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Biolink Blocks Access')}}</label>
                     <select 
                        required
                        name="biolink_blocks" 
                        class="form-control px-2"
                     >
                        <option value="0" @if($plan->biolink_blocks == '0') selected @endif>
                            {{__('Not')}}
                        </option>
                        <option value="1" @if($plan->biolink_blocks == '1') selected @endif>
                            {{__('1')}}
                        </option>
                        <option value="2" @if($plan->biolink_blocks == '2') selected @endif>
                            {{__('2')}}
                        </option>
                        <option value="3" @if($plan->biolink_blocks == '3') selected @endif>
                            {{__('3')}}
                        </option>
                        <option value="4" @if($plan->biolink_blocks == '4') selected @endif>
                            {{__('4')}}
                        </option>
                        <option value="5" @if($plan->biolink_blocks == '5') selected @endif>
                            {{__('5')}}
                        </option>
                        <option value="6" @if($plan->biolink_blocks == '6') selected @endif>
                            {{__('6')}}
                        </option>
                        <option value="7" @if($plan->biolink_blocks == '7') selected @endif>
                            {{__('7')}}
                        </option>
                        <option value="8" @if($plan->biolink_blocks == '8') selected @endif>
                            {{__('8')}}
                        </option>
                        <option value="9" @if($plan->biolink_blocks == '9') selected @endif>
                            {{__('All')}}
                        </option>
                     </select>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">{{__('Shortlink Create')}}</label>
                        <div class="form-check reverse">
                           <input 
                              id="shortlink"
                              type="checkbox" 
                              class="form-check-input" 
                              @if($plan->shortlinks == 'Unlimited') checked @endif
                           >
                           <label class="form-check-label" for="shortlink">
                              {{__('Unlimited')}}
                           </label>
                        </div>
                     </div>
                     <input 
                        required
                        id="shortlinks"
                        type="number" 
                        name="shortlinks"
                        value="{{$plan->shortlinks}}"
                        placeholder="How many shortlinks can create"
                        class="form-control px-2" 
                     >
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">{{__('Project Create')}}</label>
                        <div class="form-check reverse">
                           <input 
                              id="project"
                              type="checkbox" 
                              class="form-check-input" 
                              @if($plan->projects == 'Unlimited') checked @endif
                           >
                           <label class="form-check-label" for="project">
                              {{__('Unlimited')}}
                           </label>
                        </div>
                     </div>
                     <input 
                        required
                        id="projects"
                        type="number" 
                        name="projects"
                        value="{{$plan->projects}}"
                        placeholder="How many projects can create"
                        class="form-control px-2" 
                     >
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">{{__('QR Code Create')}}</label>
                        <div class="form-check reverse">
                           <input 
                              id="qrcode"
                              type="checkbox" 
                              class="form-check-input" 
                              @if($plan->qrcodes == 'Unlimited') checked @endif
                           >
                           <label class="form-check-label" for="qrcode">
                              {{__('Unlimited')}}
                           </label>
                        </div>
                     </div>
                     <input 
                        required
                        id="qrcodes"
                        type="number" 
                        name="qrcodes"
                        value="{{$plan->qrcodes}}"
                        placeholder="How many qrcodes can create"
                        class="form-control px-2" 
                     >
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Theme Access')}}</label>
                     <select 
                        required
                        name="themes" 
                        class="form-control px-2"
                     >
                        <option value="Free" @if($plan->themes == 'Free') selected @endif>
                            {{__('Free Only')}}
                        </option>
                        <option value="Standard" @if($plan->themes == 'Standard') selected @endif>
                            {{__('Standard (Free Themes Included)')}}
                        </option>
                        <option value="Premium" @if($plan->themes == 'Premium') selected @endif>
                            {{__('Premium (All Themes Included)')}}
                        </option>
                     </select>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Custom Theme Create Access')}}</label>
                     <select 
                        required
                        name="custom_theme" 
                        class="form-control px-2"
                     >
                        <option value="1" @if($plan->custom_theme == '1') selected @endif>
                            {{__('True')}}
                        </option>
                        <option value="0" @if($plan->custom_theme == '0') selected @endif>
                            {{__('False')}}
                        </option>
                     </select>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Support Response Hours')}}</label>
                     <select 
                        required
                        name="support" 
                        class="form-control px-2"
                     >
                        <option value="24" @if($plan->support == '24') selected @endif>
                            {{__('24')}}
                        </option>
                        <option value="48" @if($plan->support == '48') selected @endif>
                            {{__('48')}}
                        </option>
                        <option value="72" @if($plan->support == '72') selected @endif>
                            {{__('72')}}
                        </option>
                     </select>
                  </div>
               </div>

               <button 
                  type="submit" 
                  style="max-width: 180px"
                  class="mt-3 btn btn-primary"
               >
                  {{__('Update Plan')}}
               </button>
            </form>
         </div>
      </div>
   </div>
@endsection