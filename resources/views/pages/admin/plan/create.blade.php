@extends('layouts.dashboard.dashboard')

@section('content')
   <div class="container mt-3 mb-4">
      <h4 class="mb-5" style="font-size: 24px">{{__('Create New Pricing Plan')}}</h4>
      
      <div class="row">
         <div class="col-lg-10 mx-auto">
            <form class="card p-4" method="POST" action="{{route('plan.store')}}">
               @csrf

               <div class="row">
                  <h5 class="mb-4">{{__('Pyement Info')}}</h5>
                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Plan Name')}}</label>
                     <select 
                        required
                        name="name" 
                        class="form-control px-2"
                     >
                        <option value="BASIC">{{__('BASIC')}}</option>
                        <option value="STANDARD">{{__('STANDARD')}}</option>
                        <option value="PREMIUM">{{__('PREMIUM')}}</option>
                     </select>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Description')}}</label>
                     <input 
                        required 
                        name="description"
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
                        placeholder="Yearly plan price"
                        class="form-control px-2" 
                     >
                  </div>
   
                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Currency')}}</label>
                     <select required class="form-control px-2" name="currency" id="currency"></select>

                     <script src="{{asset('js/currencies.js')}}"></script>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Plan Status')}}</label>
                     <select 
                        required
                        name="status" 
                        class="form-control px-2"
                     >
                        <option value="active">{{__('Active')}}</option>
                        <option value="deactive">{{__('Deactive')}}</option>
                     </select>
                  </div>

                  {{-- Plan features from here --}}
                  <h5 class="my-4">{{__('Features Info')}}</h5>
                  <div class="col-12 col-md-6 mb-3">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">{{__('Biolink Create')}}</label>
                        <div class="form-check reverse">
                           <input class="form-check-input" type="checkbox" id="biolink">
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
                        <option value="0" selected>{{__('Not')}}</option>
                        <option value="1">{{__('1')}}</option>
                        <option value="2">{{__('2')}}</option>
                        <option value="3">{{__('3')}}</option>
                        <option value="4">{{__('4')}}</option>
                        <option value="5">{{__('5')}}</option>
                        <option value="6">{{__('6')}}</option>
                        <option value="7">{{__('7')}}</option>
                        <option value="8">{{__('8')}}</option>
                        <option value="9">{{__('9')}}</option>
                        <option value="9">{{__('All')}}</option>
                     </select>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">{{__('Shortlink Create')}}</label>
                        <div class="form-check reverse">
                           <input class="form-check-input" type="checkbox" id="shortlink">
                           <label class="form-check-label" for="shortlink">
                              {{__('Unlimited')}}
                           </label>
                        </div>
                     </div>
                     <input 
                        required
                        type="number" 
                        id="shortlinks"
                        name="shortlinks"
                        placeholder="How many shortlinks can create"
                        class="form-control px-2" 
                     >
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">{{__('Project Create')}}</label>
                        <div class="form-check reverse">
                           <input class="form-check-input" type="checkbox" id="project">
                           <label class="form-check-label" for="project">
                              {{__('Unlimited')}}
                           </label>
                        </div>
                     </div>
                     <input 
                        required
                        type="number" 
                        id="projects"
                        name="projects"
                        placeholder="How many projects can create"
                        class="form-control px-2" 
                     >
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">{{__('QR Code Create')}}</label>
                        <div class="form-check reverse">
                           <input class="form-check-input" type="checkbox" id="qrcode">
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
                        <option value="Free" selected>{{__('Free Only')}}</option>
                        <option value="Standard">{{__('Standard (Free Themes Included)')}}</option>
                        <option value="Premium">{{__('Premium (All Themes Included)')}}</option>
                     </select>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Custom Theme Create Access')}}</label>
                     <select 
                        required
                        name="custom_theme" 
                        class="form-control px-2"
                     >
                        <option value="1">{{__('True')}}</option>
                        <option value="0" selected>{{__('False')}}</option>
                     </select>
                  </div>

                  <div class="col-12 col-md-6 mb-3">
                     <label class="form-label">{{__('Support Response Hours')}}</label>
                     <select 
                        required
                        name="support" 
                        class="form-control px-2"
                     >
                        <option value="24" selected>{{__('24')}}</option>
                        <option value="48">{{__('48')}}</option>
                        <option value="72">{{__('72')}}</option>
                     </select>
                  </div>
               </div>

               <button 
                  type="submit" 
                  style="max-width: 180px"
                  class="mt-3 btn btn-primary"
               >
                  {{__('Create Plan')}}
               </button>
            </form>
         </div>
      </div>
   </div>
@endsection