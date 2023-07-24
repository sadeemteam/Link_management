<section id="#testimonials" class="testimonials container splide py-5">
   <div class="text-center py-4">
      <h1 class="fw-bold" style="font-size: 36px">{{__('Testimonials')}}</h1>
      <p class="pt-3">{{__('What our client says about us.')}}</p>
  </div>

   <div class="splide__track">
       <ul class="splide__list">
         @foreach($testimonials as $item)
            <li class="splide__slide" data-aos-duration="1000" data-aos="fade-up">
               <div class="card border-0 styled-card" style="max-height: 280px; height: 100%;" >
                  <img 
                     class="customer-img" 
                     alt="customer-img"
                     src="{{asset($item->thumbnail)}}" 
                  >
                  <p>{{$item->testimonial}}</p>

                  <div class="border-top my-3"></div>

                  <h5 class="text-primary fw-bold" style="font-size: 18px">
                     {{$item->name}}
                  </h5>
                  <p style="font-size: 14px">{{$item->title}}</p>
               </div>
            </li>
         @endforeach
       </ul>
   </div>

   <script>
      var splide = new Splide( '.splide', {
         type   : 'loop',
         perPage: 3,
         focus  : 'center',
         breakpoints: {
            900: {
               perPage: 2,
            },
            600: {
               perPage: 1,
            },
         },
      });

      splide.mount();
   </script>
 </section>