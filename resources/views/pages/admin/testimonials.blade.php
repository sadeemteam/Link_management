@extends('layouts.dashboard.dashboard')

@section('content')
<div class="container pricing mt-3 mb-4">
    <div class="d-flex justify-content-between pb-4">
        <h5 style="font-size: 22px">{{__('Testimonials')}}</h5>
        <button 
            data-bs-toggle="modal"
            data-bs-target="#addTestimonial"
            class="type-button btn btn-primary text-white" 
        >
            <i class="fa-solid fa-circle-plus" style="font-size: 14px" ></i>
            {{__('Add Testimonial')}}
        </button>

        @include('components.testimonials.AddTestimonial')
    </div>

    <div class="row">
        @foreach($testimonials as $item)
            <div class="col-lg-4">
                <div class="card border-0 styled-card" style="margin-top: 80px; positon: relative;">
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

                    <form 
                        method="POST" 
                        action="/dashboard/testimonial/delete/{{$item->id}}"
                        style="position: absolute; top: 10px; right: 10px;" 
                    >
                        @csrf
                        @method("DELETE")

                        <button type="submit" class="btn p-0">
                            <i 
                                style="cursor: pointer; font-size: 26px;" 
                                class="fa-solid fa-circle-trash text-danger"
                            ></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection