@extends('layouts.dashboard.dashboard')

@section('content')
<div class="container">
   <div class="card p-4 mb-4 themes mt-4">
      <h4 class="mb-2">{{__('Premium Themes')}}</h4>
      <div class="row themeContainer">
         @foreach($themes as $theme)
            <div class="col-6 col-lg-2 p-3">
               <div class="theme">
                  <div class="badge">
                     <span>{{$theme->type}}</span>
                     <form class="status" action="/dashboard/themes/type/{{$theme->id}}" method="POST">
                        @csrf
                        @method('PUT')

                        <select name="type" class="theme-type">
                           <option 
                              value="Free"
                              @if($theme->type == 'Free') @selected(true) @else @selected(false) @endif
                           >
                              Free
                           </option>
                           <option 
                              value="Standard"
                              @if($theme->type == 'Standard') @selected(true) @else @selected(false) @endif
                           >
                              Standard
                           </option>
                           <option 
                              value="Premium" 
                              @if($theme->type == 'Premium') @selected(true) @else @selected(false) @endif 
                           >
                              Premium
                           </option>
                        </select>
                     </form>
                  </div>
                  <img class="card" width="100%" src="{{asset($theme->theme_demo)}}" alt="">
               </div>
               <h6 class="text-center mt-2">
                  {{$theme->name}}
               </h6>
            </div>
         @endforeach
      </div>
   </div>
</div>
<script>
   const themeType = document.querySelectorAll(".theme-type");
   if (themeType) {
      themeType.forEach((element) => {
         element.addEventListener("change", (event) => {
            event.target.form.submit();
         });
      });
   }
</script>
@endsection
