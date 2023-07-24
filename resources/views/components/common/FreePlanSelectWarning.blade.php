<button 
    type="button"
    data-bs-toggle="modal" 
    data-bs-target="#{{$type}}"
    class="form-control type-button btn btn-primary text-white" 
>
    {{__('Select Plan')}}
</button>
  
<div class="modal fade" id="{{$type}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" class="p-5" action="{{route('basic-plan', $plan->id)}}">
                @csrf
                <h3 class="text-danger text-center mb-5">Are you sure to select free plan?</h3>

                <button 
                    type="submit"
                    class="form-control type-button btn btn-danger text-white" 
                >
                    {{__('Continue')}}
                </button>
            </form>
        </div>
    </div>
</div>